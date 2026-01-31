<?php

namespace App\Livewire;

use App\Models\Translation;
use Livewire\Component;

class SearchTranslations extends Component
{
    public $searchQuery = '';
    public $searchResults = [];
    public $isSearching = false;
    public $showResults = false;

    public function mount()
    {
        $this->searchResults = collect();
    }

    public function updatedSearchQuery()
    {
        if (strlen(trim($this->searchQuery)) >= 2) {
            $this->performSearch();
        } else {
            $this->resetSearch();
        }
    }

    public function performSearch()
    {
        $this->isSearching = true;
        $this->showResults = true;

        $searchQuery = trim($this->searchQuery);

        $this->searchResults = Translation::with([
                'work.originalLanguage',
                'language',
                'translator.user',
                'ratings'
            ])
            ->whereHas('work', function($query) use ($searchQuery) {
                $query->where('title', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('description', 'LIKE', "%{$searchQuery}%")
                      ->orWhere('author_name', 'LIKE', "%{$searchQuery}%");
            })
            ->orWhereHas('language', function($query) use ($searchQuery) {
                $query->where('lang_name', 'LIKE', "%{$searchQuery}%");
            })
            ->orWhereHas('translator.user', function($query) use ($searchQuery) {
                $query->where('name', 'LIKE', "%{$searchQuery}%");
            })
            ->where('status', 'published')
            ->latest('updated_at')
            ->limit(15)
            ->get()
            ->map(function ($translation) {
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

        $this->isSearching = false;
    }

    public function resetSearch()
    {
        $this->searchResults = collect();
        $this->showResults = false;
        $this->isSearching = false;
    }

    public function clearSearch()
    {
        $this->searchQuery = '';
        $this->resetSearch();
    }

    private function getWorkDescription($work)
    {
        if (!empty($work->description)) {
            return $work->description;
        }
        return "'{$work->title}' asari muallif {$work->author_name} tomonidan yozilgan {$work->originalLanguage->lang_name} tilidagi asar.";
    }

    private function getLanguageCode($languageName)
    {
        $codes = [
            'English' => 'EN', 'French' => 'FR', 'Russian' => 'RU', 'Uzbek' => 'UZ',
            'Arabic' => 'AR', 'Spanish' => 'ES', 'German' => 'DE', 'Italian' => 'IT',
            'Chinese' => 'CN', 'Japanese' => 'JP', 'Korean' => 'KR',
        ];
        return $codes[$languageName] ?? strtoupper(substr($languageName, 0, 2));
    }

    private function getTranslatorImageUrl($profileImageUrl)
    {
        if (empty($profileImageUrl)) {
            return null;
        }
        if (str_starts_with($profileImageUrl, 'http')) {
            return $profileImageUrl;
        }
        if (str_starts_with($profileImageUrl, 'storage/')) {
            return asset($profileImageUrl);
        }
        return asset('storage/' . ltrim($profileImageUrl, '/'));
    }

    public function render()
    {
        return view('livewire.search-translations');
    }
}
