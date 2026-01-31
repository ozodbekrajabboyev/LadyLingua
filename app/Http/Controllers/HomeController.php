<?php

namespace App\Http\Controllers;

use App\Models\Translation;
use App\Models\Rating;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get latest published translations with all relationships
        $latestTranslations = Translation::with([
                'work.originalLanguage',
                'language',
                'translator.user',
                'ratings'
            ])
            ->where('status', 'published')
            ->latest('updated_at')
            ->limit(6)
            ->get()
            ->map(function ($translation) {
                // Calculate average rating
                $avgRating = $translation->ratings()->avg('stars') ?? 0;

                return [
                    'id' => $translation->id,
                    'title' => $translation->work->title,
                    'description' => $this->getWorkDescription($translation->work),
                    'language_from' => $this->getLanguageCode($translation->work->originalLanguage->lang_name),
                    'language_to' => $this->getLanguageCode($translation->language->lang_name),
                    'rating' => $avgRating > 0 ? number_format($avgRating, 1) : '0.0',
                    'translator_name' => $translation->translator->user->name,
                        'translator_image' => $this->getTranslatorImageUrl($translation->translator->profile_image_url),
                    'time_ago' => $translation->updated_at->diffForHumans(),
                    'price' => $translation->price,
                    'author_name' => $translation->work->author_name,
                ];
            });

        return view('home', compact('latestTranslations'));
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
     * Get language code for display
     */
    private function getLanguageCode($languageName)
    {
        $codes = [
            'English' => 'EN',
            'French' => 'FR',
            'Russian' => 'RU',
            'Uzbek' => 'UZ',
            'Arabic' => 'AR',
            'Spanish' => 'ES',
            'German' => 'DE',
            'Italian' => 'IT',
            'Chinese' => 'CN',
            'Japanese' => 'JP',
            'Korean' => 'KR',
        ];

        return $codes[$languageName] ?? strtoupper(substr($languageName, 0, 2));
    }

    /**
     * Get properly formatted translator image URL
     */
    private function getTranslatorImageUrl($profileImageUrl)
    {
        if (empty($profileImageUrl)) {
            return null;
        }

        // If it's already a full URL (starts with http), return as is
        if (str_starts_with($profileImageUrl, 'http')) {
            return $profileImageUrl;
        }

        // If it's a local path, use asset() helper
        return asset('storage/' . $profileImageUrl);
    }
}
