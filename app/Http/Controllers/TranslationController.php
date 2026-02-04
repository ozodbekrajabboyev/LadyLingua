<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationShowRequest;
use App\Http\Traits\HandlesLanguageCodes;
use App\Models\Translation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TranslationController extends Controller
{
    use HandlesLanguageCodes;
    public function index()
    {
        // Get all published translations with all relationships using pagination
        $translations = Translation::with([
                'work.originalLanguage',
                'language',
                'translator.user',
                'ratings'
            ])
            ->where('status', 'published')
            ->latest('updated_at')
            ->paginate(4) // 3 translations per page to show pagination with current data
            ->through(function ($translation) {
                // Calculate average rating
                $avgRating = $translation->ratings()->avg('stars') ?? 0;

                return [
                    'id' => $translation->id,
                    'title' => $translation->work->title,
                    'description' => $this->getWorkDescription($translation->work),
                    'language' => $this->getLanguageCode($translation->work->originalLanguage->lang_name) . ' → ' . $this->getLanguageCode($translation->language->lang_name),
                    'rating' => $avgRating > 0 ? number_format($avgRating, 1) : '0.0',
                    'translator' => $translation->translator->user->name,
                    'avatar' => $this->getTranslatorImageUrl($translation->translator->profile_image_url, $translation->translator->user->name),
                    'time' => $translation->updated_at->diffForHumans(),
                ];
            });

        return view('translations.index', compact('translations'));
    }

    /**
     * Show individual translation details
     */
    public function show($id, TranslationShowRequest $request = null)
    {
        // Handle both GET requests (with route parameter) and POST requests (with form data)
        if ($request && $request->has('id')) {
            $id = $request->validated()['id'];
        }

        // Find translation with all necessary relationships
        $translation = Translation::with([
            'work.originalLanguage',
            'language',
            'translator.user',
            'ratings.user',
            'comments.user',
            'upload'
        ])
        ->where('status', 'published')
        ->findOrFail($id);

        // Calculate translation statistics
        $avgRating = $translation->ratings->avg('stars') ?? 0;
        $totalReviews = $translation->ratings->count() + $translation->comments->count();

        // Get recent reviews (limit to 5 for initial display)
        $recentReviews = $translation->ratings()
            ->with('user')
            ->latest()
            ->limit(5)
            ->get()
            ->map(function ($rating) {
                return [
                    'id' => $rating->id,
                    'user_name' => $rating->user->name,
                    'user_avatar' => $this->getTranslatorImageUrl(null, $rating->user->name),
                    'rating' => $rating->stars,
                    'comment' => $rating->comment ?? '',
                    'date' => $rating->created_at->diffForHumans(),
                ];
            });

        // Prepare translation data
        $translationData = [
            'id' => $translation->id,
            'title' => $translation->work->title,
            'author' => $translation->work->author_name,
            'description' => $this->getWorkDescription($translation->work),
            'language_from' => $this->getLanguageCode($translation->work->originalLanguage->lang_name),
            'language_to' => $this->getLanguageCode($translation->language->lang_name),
            'rating' => $avgRating > 0 ? number_format($avgRating, 1) : '0.0',
            'total_reviews' => $totalReviews,
            'price' => $translation->price ?? 0,
            'preview_pages' => $translation->preview_pages_cnt ?? 10,
            'total_pages' => $translation->work->total_pages ?? 100,
            'translator_name' => $translation->translator->user->name,
            'translator_avatar' => $this->getTranslatorImageUrl($translation->translator->profile_image_url, $translation->translator->user->name),
            'translator_id' => $translation->translator->id,
            'updated_at' => $translation->updated_at->diffForHumans(),
            'preview_pdf_path' => $translation->preview_pdf_path ? \Storage::disk('public')->url($translation->preview_pdf_path) : null,
            'full_pdf_path' => $translation->full_pdf_path ? \Storage::disk('public')->url($translation->full_pdf_path) : null,
        ];

        // Get related translations from the same translator (limit to 3)
        $relatedTranslations = Translation::with(['work.originalLanguage', 'language', 'ratings'])
            ->where('translator_id', $translation->translator_id)
            ->where('id', '!=', $translation->id)
            ->where('status', 'published')
            ->latest()
            ->limit(3)
            ->get()
            ->map(function ($relatedTranslation) {
                $relatedRating = $relatedTranslation->ratings->avg('stars') ?? 0;
                return [
                    'id' => $relatedTranslation->id,
                    'title' => $relatedTranslation->work->title,
                    'language_from' => $this->getLanguageCode($relatedTranslation->work->originalLanguage->lang_name),
                    'language_to' => $this->getLanguageCode($relatedTranslation->language->lang_name),
                    'rating' => $relatedRating > 0 ? number_format($relatedRating, 1) : '0.0',
                    'price' => $relatedTranslation->price ?? 0,
                ];
            });

        return view('translations.show', compact('translationData', 'recentReviews', 'relatedTranslations'));
    }

    /**
     * Get work description with fallback to generated description
     */
    private function getWorkDescription($work)
    {
        // If work has a description, use it
        if (!empty($work->description)) {
            return $work->description;
        }

        // Otherwise, generate a default description
        return "'{$work->title}' asari muallif {$work->author_name} tomonidan yozilgan {$work->originalLanguage->lang_name} tilidagi asar.";
    }


    /**
     * Get properly formatted translator image URL with fallback to initials avatar
     */
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

        // Generate initials-based avatar URL using UI Avatars service
        if ($translatorName) {
            $initials = $this->getInitials($translatorName);
            $backgroundColor = $this->getColorFromName($translatorName);
            return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=" . $backgroundColor . "&color=ffffff&size=64&font-size=0.5&rounded=true&bold=true";
        }

        // Final fallback
        return asset('images/default-avatar.svg');
    }

    /**
     * Get initials from full name
     */
    private function getInitials($name)
    {
        $parts = explode(' ', trim($name));
        if (count($parts) >= 2) {
            return strtoupper(substr($parts[0], 0, 1) . substr($parts[1], 0, 1));
        }
        return strtoupper(substr($name, 0, 2));
    }

    /**
     * Generate consistent color from name for avatar background
     */
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
}
