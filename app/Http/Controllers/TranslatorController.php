<?php

namespace App\Http\Controllers;

use App\Http\Traits\SanitizesHtmlContent;
use App\Http\Traits\HandlesLanguageCodes;
use App\Models\TranslatorPortfolio;
use App\Models\Translation;
use Illuminate\Http\Request;

class TranslatorController extends Controller
{
    use SanitizesHtmlContent, HandlesLanguageCodes;
    public function index()
    {
        // Get all translator portfolios with their relationships and pagination
        $translators = TranslatorPortfolio::with([
                'user',
                'translations.ratings',
                'translations.work.originalLanguage',
                'translations.language',
                'languages'
            ])
            ->whereHas('user') // Only get translators with valid user accounts
            ->paginate(5) // 2 translators per page to show pagination with current data
            ->through(function ($translator) {
                // Calculate ratings from all translations
                $allRatings = $translator->translations->flatMap(function($translation) {
                    return $translation->ratings;
                });

                $avgRating = $allRatings->avg('stars') ?? 0;
                $reviewCount = $allRatings->count();

                return [
                    'id' => $translator->id,
                    'name' => $translator->user->name,
                    'avatar' => $this->getTranslatorImageUrl($translator->profile_image_url, $translator->user->name),
                    'rating' => $avgRating > 0 ? number_format($avgRating, 1) : '0.0',
                    'reviews' => $reviewCount,
                    'description' => $this->cleanBioContent($translator->bio) ?? 'Professional translator with extensive experience in various fields.',
                    'languages' => $this->getTranslatorLanguages($translator),
                ];
            });

        return view('translators.index', compact('translators'));
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
