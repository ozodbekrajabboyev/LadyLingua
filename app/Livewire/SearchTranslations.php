<?php

namespace App\Livewire;

use App\Http\Traits\HandlesLanguageCodes;
use App\Models\Translation;
use Livewire\Component;

class SearchTranslations extends Component
{
    use HandlesLanguageCodes;
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
                    'translator_image' => $this->getTranslatorImageUrl($translation->translator->profile_image_url, $translation->translator->user->name),
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


    private function getTranslatorImageUrl($profileImageUrl, $translatorName = null)
    {
        if (!empty($profileImageUrl)) {
            if (str_starts_with($profileImageUrl, 'http')) {
                return $profileImageUrl;
            }
            if (str_starts_with($profileImageUrl, 'storage/')) {
                return asset($profileImageUrl);
            }
            return asset('storage/' . ltrim($profileImageUrl, '/'));
        }

        // Generate initials-based avatar URL using UI Avatars service
        if ($translatorName) {
            $initials = $this->getInitials($translatorName);
            $backgroundColor = $this->getColorFromName($translatorName);
            return "https://ui-avatars.com/api/?name=" . urlencode($initials) . "&background=" . $backgroundColor . "&color=ffffff&size=64&font-size=0.5&rounded=true&bold=true";
        }

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

    public function render()
    {
        return view('livewire.search-translations');
    }
}
