<?php

namespace App\Livewire;

use App\Models\Rating;
use App\Models\Comment;
use Livewire\Component;

class TranslationStats extends Component
{
    public $translationId;
    public $averageRating = 0;
    public $totalReviews = 0;

    protected $listeners = ['rating-submitted' => 'refreshStats', 'comment-submitted' => 'refreshStats'];

    public function mount($translationId)
    {
        $this->translationId = $translationId;
        $this->updateStats();
    }

    public function refreshStats()
    {
        $this->updateStats();
    }

    protected function updateStats()
    {
        $this->averageRating = Rating::getAverageRating($this->translationId);
        $this->totalReviews = Rating::getTotalRatings($this->translationId) + Comment::where('translation_id', $this->translationId)->count();
    }

    public function render()
    {
        return view('livewire.translation-stats');
    }
}
