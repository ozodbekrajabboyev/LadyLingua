<?php

namespace App\Livewire;

use App\Models\Rating;
use App\Models\Translation;
use Livewire\Component;
use Livewire\WithPagination;

class RatingsDisplay extends Component
{
    use WithPagination;

    public $translationId;
    public $averageRating = 0;
    public $totalRatings = 0;
    public $perPage = 5;
    public $showAll = false;

    protected $listeners = ['rating-submitted' => 'refreshRatings', 'comment-submitted' => 'refreshRatings'];

    public function mount($translationId)
    {
        $this->translationId = $translationId;
        $this->updateRatingStats();
    }

    public function refreshRatings()
    {
        $this->updateRatingStats();
        $this->resetPage();
    }

    public function loadMore()
    {
        $this->perPage += 5;
    }

    public function showAllReviews()
    {
        $this->showAll = true;
        $this->perPage = 20;
    }

    protected function updateRatingStats()
    {
        $this->averageRating = Rating::getAverageRating($this->translationId);
        $this->totalRatings = Rating::getTotalRatings($this->translationId);
    }

    public function getRatingsProperty()
    {
        // Get ratings with comments
        $ratings = Rating::where('translation_id', $this->translationId)
            ->withUser()
            ->latest()
            ->limit($this->showAll ? 10 : $this->perPage)
            ->get()
            ->map(function ($rating) {
                return [
                    'id' => 'rating-' . $rating->id,
                    'user_id' => $rating->user_id,
                    'user_name' => $rating->user->name,
                    'user_avatar' => $this->getTranslatorImageUrl(null, $rating->user->name),
                    'rating' => $rating->stars,
                    'comment' => $rating->formatted_comment,
                    'date' => $rating->created_at->diffForHumans(),
                    'created_at' => $rating->created_at,
                    'type' => 'rating'
                ];
            });

        // Get separate comments
        $comments = \App\Models\Comment::where('translation_id', $this->translationId)
            ->with('user')
            ->latest()
            ->limit($this->showAll ? 10 : $this->perPage)
            ->get()
            ->map(function ($comment) {
                // Get user's current rating for this translation
                $userRating = Rating::where('translation_id', $this->translationId)
                    ->where('user_id', $comment->user_id)
                    ->latest('created_at')  // Get the most recent rating
                    ->first();

                return [
                    'id' => 'comment-' . $comment->id,
                    'user_id' => $comment->user_id,
                    'user_name' => $comment->user->name,
                    'user_avatar' => $this->getTranslatorImageUrl(null, $comment->user->name),
                    'rating' => $userRating ? $userRating->stars : 0, // Use user's current star rating
                    'comment' => $comment->content,
                    'date' => $comment->created_at->diffForHumans(),
                    'created_at' => $comment->created_at,
                    'type' => 'comment'
                ];
            });

        // Combine and sort by created_at
        return $ratings->concat($comments)
            ->sortByDesc('created_at')
            ->take($this->showAll ? 20 : $this->perPage)
            ->values();
    }

    public function getHasMoreRatingsProperty()
    {
        if ($this->showAll) {
            return false;
        }

        $totalRatings = Rating::where('translation_id', $this->translationId)->count();
        $totalComments = \App\Models\Comment::where('translation_id', $this->translationId)->count();
        $totalCount = $totalRatings + $totalComments;

        return $totalCount > $this->perPage;
    }

    /**
     * Get properly formatted translator image URL with fallback to initials avatar
     */
    private function getTranslatorImageUrl($profileImageUrl, $translatorName = null)
    {
        if (!empty($profileImageUrl)) {
            if (str_starts_with($profileImageUrl, 'http')) {
                return $profileImageUrl;
            }
            return asset('storage/' . $profileImageUrl);
        }

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
            '6366f1', '8b5cf6', '06b6d4', '10b981', 'f59e0b',
            'ef4444', 'ec4899', '84cc16', 'f97316', '3b82f6'
        ];

        $hash = md5($name);
        $index = hexdec(substr($hash, 0, 2)) % count($colors);
        return $colors[$index];
    }

    public function render()
    {
        return view('livewire.ratings-display');
    }
}
