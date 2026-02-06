<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Translation;
use App\Models\Work;
use App\Models\AvailableLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with([
            'user',
            'work.originalLanguage',
            'language',
            'translator.user'
        ]);

        // Filter by authenticated user's orders only
        if (Auth::check()) {
            $query->where('user_id', Auth::id());
        }

        // Enhanced search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                // Search by ID (with or without # prefix)
                $searchId = str_replace('#', '', $search);
                if (is_numeric($searchId)) {
                    $q->where('id', $searchId);
                } else {
                    // Search by project title, description, or translator name
                    $q->whereHas('work', function($workQuery) use ($search) {
                        $workQuery->where('title', 'like', "%{$search}%")
                                 ->orWhere('author_name', 'like', "%{$search}%")
                                 ->orWhere('description', 'like', "%{$search}%");
                    })->orWhereHas('translator.user', function($translatorQuery) use ($search) {
                        $translatorQuery->where('name', 'like', "%{$search}%");
                    });
                }
            });
        }

        // Status filter functionality
        if ($request->filled('status') && $request->get('status') !== 'all') {
            $status = $request->get('status');

            if ($status === 'completed') {
                // For 'completed' status, include both:
                // 1. Orders with status = 'completed'
                // 2. Orders that have published translations (checking via the relationship logic)
                $query->where(function($q) {
                    $q->where('status', 'completed')
                      ->orWhere(function($subQuery) {
                          // Find orders that have published translations
                          $subQuery->whereExists(function($existsQuery) {
                              $existsQuery->select(DB::raw(1))
                                         ->from('translations')
                                         ->whereColumn('translations.work_id', 'orders.work_id')
                                         ->whereColumn('translations.translator_id', 'orders.translator_id')
                                         ->whereColumn('translations.language_id', 'orders.language_id')
                                         ->where('translations.status', 'published');
                          });
                      });
                });
            } else {
                // Map frontend status to backend status for other cases
                $statusMap = [
                    'pending' => 'pending',
                    'progress' => ['accepted', 'in_progress']
                ];

                if (isset($statusMap[$status])) {
                    if (is_array($statusMap[$status])) {
                        $query->whereIn('status', $statusMap[$status]);
                    } else {
                        $query->where('status', $statusMap[$status]);
                    }
                }
            }
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $orders = $query->paginate(10);

        // Transform orders to include additional data needed for the enhanced UI
        $orders->getCollection()->transform(function ($order) {
            // Find related translation if exists using the helper method
            $translation = $order->getTranslation();

            // Map status for frontend - check translation status first
            $displayStatus = 'pending';
            if ($translation && $translation->status === 'published') {
                $displayStatus = 'completed';
            } else {
                $statusMap = [
                    'pending' => 'pending',
                    'accepted' => 'progress',
                    'in_progress' => 'progress',
                    'completed' => 'completed',
                    'rejected' => 'pending',
                    'cancelled' => 'pending'
                ];
                $displayStatus = $statusMap[$order->status] ?? 'pending';
            }

            // Handle translator profile image properly
            $avatarUrl = null;
            if ($order->translator && $order->translator->profile_image_url) {
                $profileImage = $order->translator->profile_image_url;

                // Check if it's already a full URL
                if (filter_var($profileImage, FILTER_VALIDATE_URL)) {
                    $avatarUrl = $profileImage;
                } else {
                    // It's a relative path, prepend storage URL
                    $avatarUrl = asset('storage/' . $profileImage);
                }
            }

            // Enhanced data for better UI
            return [
                'id' => '#' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'title' => $order->work->title ?? 'N/A',
                'translator' => $order->translator && $order->translator->user
                    ? $order->translator->user->name
                    : null,
                'avatar' => $avatarUrl,
                'status' => $displayStatus,
                'date' => $order->created_at->format('d M, Y'),
                'price' => $translation ? number_format($translation->price, 0, '.', ',') . ' UZS' : 'Narx belgilanmagan',
                'action' => $this->getActionForStatus($order->status, $translation),
                'deadline' => $order->deadline ? $order->deadline->format('d M, Y') : null,
                'raw_status' => $order->status,
                'translation_exists' => $translation !== null,
                'translation_status' => $translation ? $translation->status : null,
                'translation_id' => $translation ? $translation->id : null,
                // Additional data for enhanced UI
                'work_description' => $order->work->description ?? null,
                'language_pair' => ($order->work->originalLanguage->lang_name ?? 'N/A') . ' → ' . ($order->language->lang_name ?? 'N/A'),
                'created_at_human' => $order->created_at->diffForHumans(),
                'priority' => $this->calculateOrderPriority($order, $translation),
            ];
        });

        return view('orders.index', compact('orders'));
    }

    /**
     * Calculate order priority for UI enhancements
     */
    private function calculateOrderPriority($order, $translation)
    {
        if ($translation && $translation->status === 'published') {
            return 'low'; // Completed orders have low priority
        }

        if ($order->deadline && $order->deadline->isPast()) {
            return 'high'; // Overdue orders have high priority
        }

        if ($order->deadline && $order->deadline->diffInDays(now()) <= 3) {
            return 'medium'; // Due soon orders have medium priority
        }

        return 'low'; // Default priority
    }

    /**
     * Show the form for creating a new order
     */
    public function create()
    {
        // Get available languages for the form
        $languages = AvailableLanguage::all();

        // Get available translators for the form
        $translators = \App\Models\TranslatorPortfolio::with('user')->get();

        return view('orders.order-page', compact('languages', 'translators'));
    }

    /**
     * Store a newly created order in storage
     *
     * Users select a translator from available options when creating an order.
     * The selected translator receives the order in 'pending' status for approval.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author_name' => 'required|string|max:255',
            'translator_id' => 'required|exists:translator_portfolios,id',
            'language_id' => 'required|exists:available_languages,id',
            'deadline' => 'required|date|after:now',
            'description' => 'required|string',
        ]);

        try {
            // First create the work
            $work = Work::create([
                'title' => $request->title,
                'original_language_id' => 1, // Default original language
                'author_name' => $request->author_name,
                'description' => $request->description,
            ]);

            // Create the order with user-selected translator
            $order = Order::create([
                'user_id' => Auth::id(),
                'translator_id' => $request->translator_id, // User selected translator
                'work_id' => $work->id,
                'language_id' => $request->language_id,
                'status' => 'pending', // Translator needs to accept/reject this order
                'deadline' => $request->deadline,
            ]);

            return redirect()->route('orders')->with('success', 'Buyurtma muvaffaqiyatli yaratildi! Tarjimon tasdiqlashini kutmoqda.');
        } catch (\Exception $e) {
            // Log the actual error for debugging
            \Log::error('Order creation failed: ' . $e->getMessage(), [
                'user_id' => Auth::id(),
                'request_data' => $request->all(),
                'exception' => $e
            ]);

            return back()->withErrors(['error' => 'Buyurtma yaratishda xatolik yuz berdi: ' . $e->getMessage()])->withInput();
        }
    }

    private function getActionForStatus($status, $translation = null)
    {
        // If translation exists and is published, show visibility action (eye icon) to view translation
        if ($translation && $translation->status === 'published') {
            return 'visibility';
        }

        switch ($status) {
            case 'completed':
                // Only show visibility if translation exists, otherwise show edit
                return $translation ? 'visibility' : 'edit';
            case 'in_progress':
            case 'accepted':
                return 'visibility';
            case 'pending':
                return 'edit';
            case 'rejected':
            case 'cancelled':
                return 'delete';
            default:
                return 'edit';
        }
    }
}
