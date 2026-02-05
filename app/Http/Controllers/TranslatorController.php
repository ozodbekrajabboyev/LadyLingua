<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslatorShowRequest;
use App\Http\Traits\SanitizesHtmlContent;
use App\Http\Traits\HandlesLanguageCodes;
use App\Models\TranslatorPortfolio;
use App\Models\Translation;
use App\Models\AvailableLanguage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TranslatorController extends Controller
{
    use SanitizesHtmlContent, HandlesLanguageCodes;
    public function index(Request $request)
    {
        // Get filter data from database
        $availableLanguages = AvailableLanguage::select('id', 'lang_name')
            ->whereHas('translators') // Only languages that have translators
            ->distinct()
            ->orderBy('lang_name')
            ->get();

        // Fallback to all languages if no translators have languages assigned
        if ($availableLanguages->isEmpty()) {
            $availableLanguages = AvailableLanguage::select('id', 'lang_name')
                ->orderBy('lang_name')
                ->get();
        }

        // Get available ratings (calculate from existing ratings)
        $availableRatings = collect([5, 4, 3, 2, 1])->filter(function($rating) {
            return DB::table('ratings')
                ->join('translations', 'ratings.translation_id', '=', 'translations.id')
                ->where('ratings.stars', '>=', $rating)
                ->exists();
        });

        // Fallback ratings if no ratings exist
        if ($availableRatings->isEmpty()) {
            $availableRatings = collect([5, 4, 3, 2, 1]);
        }

        // Build query with filters and search
        $query = TranslatorPortfolio::with([
                'user',
                'translations.ratings',
                'translations.work.originalLanguage',
                'translations.language',
                'languages'
            ])
            ->whereHas('user'); // Only get translators with valid user accounts

        // Apply search filter
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->whereHas('user', function($q) use ($searchTerm) {
                $q->where('name', 'LIKE', "%{$searchTerm}%");
            })
            ->orWhere('bio', 'LIKE', "%{$searchTerm}%")
            ->orWhereHas('languages', function($q) use ($searchTerm) {
                $q->where('lang_name', 'LIKE', "%{$searchTerm}%");
            });
        }

        // Apply language filter
        if ($request->filled('language')) {
            $query->whereHas('languages', function($q) use ($request) {
                $q->where('lang_name', 'LIKE', "%{$request->language}%");
            });
        }

        // Apply experience filter (we'll handle this after getting results since it requires counting)
        $experienceFilter = $request->get('experience');

        // Get paginated results
        $perPage = $request->get('per_page', 5);
        $translators = $query->paginate($perPage)->appends($request->query());

        // Transform data and apply additional filters
        $translators->through(function ($translator) use ($request, $experienceFilter) {
            // Calculate ratings from all translations
            $allRatings = $translator->translations->flatMap(function($translation) {
                return $translation->ratings;
            });

            $avgRating = $allRatings->avg('stars') ?? 0;
            $reviewCount = $allRatings->count();
            $completedProjects = $translator->translations->where('status', 'published')->count();

            $translatorData = [
                'id' => $translator->id,
                'name' => $translator->user->name,
                'avatar' => $this->getTranslatorImageUrl($translator->profile_image_url, $translator->user->name),
                'rating' => $avgRating > 0 ? number_format($avgRating, 1) : '0.0',
                'reviews' => $reviewCount,
                'completed_projects' => $completedProjects,
                'description' => $this->cleanBioContent($translator->bio) ?? 'Professional translator with extensive experience in various fields.',
                'languages' => $this->getTranslatorLanguages($translator),
                'member_since' => $translator->user->created_at,
                'is_online' => rand(0, 1), // Mock online status
                'is_verified' => $completedProjects > 10, // Mock verification
                'success_rate' => min(100, 80 + ($completedProjects * 2)), // Mock success rate
            ];

            // Apply rating filter after calculation
            if ($request->filled('rating') && $avgRating < (float)$request->rating) {
                return null;
            }

            // Apply experience filter after calculation
            if ($experienceFilter) {
                switch($experienceFilter) {
                    case 'beginner':
                        if ($completedProjects > 10) return null;
                        break;
                    case 'intermediate':
                        if ($completedProjects < 11 || $completedProjects > 50) return null;
                        break;
                    case 'expert':
                        if ($completedProjects <= 50) return null;
                        break;
                }
            }

            return $translatorData;
        });

        // Filter out null values (filtered out items)
        $translators->setCollection($translators->getCollection()->filter());

        // Apply sorting
        $sortBy = $request->get('sort', 'rating');
        $sortedCollection = $translators->getCollection();

        switch($sortBy) {
            case 'name':
                $sortedCollection = $sortedCollection->sortBy('name')->values();
                break;
            case 'reviews':
                $sortedCollection = $sortedCollection->sortByDesc('reviews')->values();
                break;
            case 'recent':
                $sortedCollection = $sortedCollection->sortByDesc('member_since')->values();
                break;
            case 'rating':
            default:
                $sortedCollection = $sortedCollection->sortByDesc(function($item) {
                    return (float)$item['rating'];
                })->values();
                break;
        }

        $translators->setCollection($sortedCollection);

        return view('translators.index', compact('translators', 'availableLanguages', 'availableRatings'));
    }

    /**
     * Show individual translator profile
     */
    public function show($id, ?TranslatorShowRequest $request = null)
    {
        // Handle both GET requests (with route parameter) and POST requests (with form data)
        if ($request && $request->has('id')) {
            $id = $request->validated()['id'];
        }

        // Find translator with all necessary relationships
        $translator = TranslatorPortfolio::with([
            'user',
            'translations.work.originalLanguage',
            'translations.language',
            'translations.ratings',
            'languages'
        ])
        ->whereHas('user')
        ->findOrFail($id);

        // Calculate overall statistics
        $allRatings = $translator->translations->flatMap(function($translation) {
            return $translation->ratings;
        });

        $avgRating = $allRatings->avg('stars') ?? 0;
        $totalReviews = $allRatings->count();
        $completedProjects = $translator->translations->where('status', 'published')->count();

        // Get completed translations for display
        $completedTranslations = $translator->translations()
            ->with(['work.originalLanguage', 'language', 'ratings'])
            ->where('status', 'published')
            ->latest('updated_at')
            ->limit(6)
            ->get()
            ->map(function ($translation) {
                $translationRating = $translation->ratings->avg('stars') ?? 0;
                return [
                    'id' => $translation->id,
                    'title' => $translation->work->title,
                    'description' => $this->getWorkDescription($translation->work),
                    'language_from' => $this->getLanguageCode($translation->work->originalLanguage->lang_name),
                    'language_to' => $this->getLanguageCode($translation->language->lang_name),
                    'rating' => $translationRating > 0 ? number_format($translationRating, 1) : '0.0',
                    'time' => $translation->updated_at->diffForHumans(),
                ];
            });

        // Prepare translator data
        $translatorData = [
            'id' => $translator->id,
            'name' => $translator->user->name,
            'email' => $translator->user->email,
            'avatar' => $this->getTranslatorImageUrl($translator->profile_image_url, $translator->user->name),
            'rating' => $avgRating > 0 ? number_format($avgRating, 1) : '0.0',
            'reviews' => $totalReviews,
            'completed_projects' => $completedProjects,
            'bio' => $this->cleanBioContent($translator->bio) ?? 'Professional translator with extensive experience in various fields.',
            'languages' => $this->getTranslatorLanguages($translator),
            'member_since' => $translator->user->created_at->format('M Y'),
            'total_earnings' => $translator->total_earnings ?? 0,
        ];

        return view('translators.show', compact('translatorData', 'completedTranslations'));
    }

    /**
     * Get work description with fallback to generated description
     */
    private function getWorkDescription($work)
    {
        if (!empty($work->description)) {
            return $work->description;
        }
        return "'{$work->title}' asari muallif {$work->author_name} tomonidan yozilgan {$work->originalLanguage->lang_name} tilidagi asar.";
    }

    /**
     * Get translator's available languages
     */
    private function getTranslatorLanguages($translator)
    {
        // Priority 1: Get languages from pivot table (translator_language)
        $assignedLanguages = collect();

        if ($translator->languages && $translator->languages->count() > 0) {
            $assignedLanguages = $translator->languages
                ->map(function($language) {
                    return $this->getLanguageCode($language->lang_name);
                })
                ->filter()
                ->unique()
                ->values();
        }

        // Priority 2: Get languages from completed translations if no assigned languages
        if ($assignedLanguages->isEmpty() && $translator->translations) {
            $translationLanguages = $translator->translations
                ->filter(function($translation) {
                    return $translation->work &&
                           $translation->work->originalLanguage &&
                           $translation->language &&
                           $translation->status === 'published';
                })
                ->flatMap(function($translation) {
                    return [
                        $this->getLanguageCode($translation->work->originalLanguage->lang_name),
                        $this->getLanguageCode($translation->language->lang_name)
                    ];
                })
                ->unique()
                ->filter()
                ->values();

            $assignedLanguages = $translationLanguages;
        }

        // Convert to array and limit to 3 languages for display
        $languages = $assignedLanguages->slice(0, 3)->toArray();

        // If still no languages found, provide defaults from available languages
        if (empty($languages)) {
            return ['EN', 'ES']; // Using languages that exist in your seeder
        }

        return $languages;
    }



    private function getTranslatorImageUrl($profileImageUrl, $translatorName = null)
    {
        if (!empty($profileImageUrl)) {
            // If it's already a full URL (starts with http), return as is
            if (str_starts_with($profileImageUrl, 'http')) {
                return $profileImageUrl;
            }
            // If it's a local path, use asset() helper
            return asset('storage/' . $profileImageUrl);
        }

        // Generate initials-based avatar URL using a service like UI Avatars
        if ($translatorName) {
            $initials = $this->getInitials($translatorName);
            $backgroundColor = $this->getColorFromName($translatorName);
            return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=" . $backgroundColor . "&color=ffffff&size=96&font-size=0.5&rounded=true&bold=true";
        }

        // Final fallback to a default avatar
        return asset('images/default-avatar.svg');
    }


    private function getInitials($name)
    {
        $parts = explode(' ', trim($name));
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }

    private function getColorFromName($name)
    {
        $colors = [
            '6366f1', // indigo
            '8b5cf6', // violet
            '06b6d4', // cyan
            '10b981', // emerald
            'f59e0b', // amber
            'ef4444', // red
            'ec4899', // pink
            '84cc16', // lime
            'f97316', // orange
            '3b82f6', // blue
        ];

        $hash = md5($name);
        $index = hexdec(substr($hash, 0, 2)) % count($colors);
        return $colors[$index];
    }

    private function cleanBioContent($bioHtml)
    {
        return $this->sanitizeBio($bioHtml);
    }
}
