<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->get('search');
            $query->where(function($q) use ($search) {
                $q->where('id', 'like', "%{$search}%")
                  ->orWhereHas('work', function($workQuery) use ($search) {
                      $workQuery->where('title', 'like', "%{$search}%");
                  });
            });
        }

        // Status filter functionality
        if ($request->filled('status') && $request->get('status') !== 'all') {
            $status = $request->get('status');
            // Map frontend status to backend status
            $statusMap = [
                'pending' => 'pending',
                'progress' => ['accepted', 'in_progress'],
                'completed' => 'completed'
            ];

            if (isset($statusMap[$status])) {
                if (is_array($statusMap[$status])) {
                    $query->whereIn('status', $statusMap[$status]);
                } else {
                    $query->where('status', $statusMap[$status]);
                }
            }
        }

        // Order by latest first
        $query->orderBy('created_at', 'desc');

        // Paginate results
        $orders = $query->paginate(10);

        // Transform orders to include additional data needed for the view
        $orders->getCollection()->transform(function ($order) {
            // Find related translation if exists using the helper method
            $translation = $order->getTranslation();

            // Map status for frontend
            $statusMap = [
                'pending' => 'pending',
                'accepted' => 'progress',
                'in_progress' => 'progress',
                'completed' => 'completed',
                'rejected' => 'pending',
                'cancelled' => 'pending'
            ];

            return [
                'id' => '#' . str_pad($order->id, 5, '0', STR_PAD_LEFT),
                'title' => $order->work->title ?? 'N/A',
                'translator' => $order->translator && $order->translator->user
                    ? $order->translator->user->name
                    : null,
                'avatar' => $order->translator && $order->translator->profile_image_url
                    ? $order->translator->profile_image_url
                    : null,
                'status' => $statusMap[$order->status] ?? 'pending',
                'date' => $order->created_at->format('d M, Y'),
                'price' => $translation ? number_format($translation->price, 0, '.', ',') . ' UZS' : 'Narx belgilanmagan',
                'action' => $this->getActionForStatus($order->status, $translation),
                'deadline' => $order->deadline->format('d M, Y'),
                'raw_status' => $order->status,
                'translation_exists' => $translation !== null
            ];
        });

        return view('orders.index', compact('orders'));
    }

    private function getActionForStatus($status, $translation = null)
    {
        switch ($status) {
            case 'completed':
                return $translation ? 'download' : 'visibility';
            case 'in_progress':
            case 'accepted':
                return 'visibility';
            case 'pending':
                return 'edit';
            case 'rejected':
            case 'cancelled':
                return 'delete';
            default:
                return 'visibility';
        }
    }
}
