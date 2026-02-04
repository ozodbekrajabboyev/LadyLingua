<?php

namespace App\Livewire;

use App\Models\Rating;
use App\Models\Translation;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RatingForm extends Component
{
    public $translationId;
    public $stars = 0;
    public $comment = '';
    public $isSubmitting = false;
    public $canRate = true;
    public $existingRating = null;
    public $showSuccess = false;
    public $successMessage = '';
    public $averageRating = 0;
    public $totalRatings = 0;

    protected $listeners = ['refreshRatings' => '$refresh'];

    public function mount($translationId)
    {
        $this->translationId = $translationId;
        $this->updateRatingStats();

        if (Auth::check()) {
            $this->existingRating = Rating::getUserRating(Auth::id(), $translationId);

            // Check if user is trying to rate their own translation
            $translation = \App\Models\Translation::find($translationId);
            if ($translation && $translation->translator->user_id === Auth::id()) {
                $this->canRate = false;
            } else {
                $this->canRate = true; // Always allow rating (for updates too)
            }

            if ($this->existingRating) {
                $this->stars = $this->existingRating->stars;
                $this->comment = $this->existingRating->comment ?? '';
            }
        } else {
            $this->canRate = false;
        }
    }

    public function setRating($rating)
    {
        $this->stars = $rating;
        $this->resetValidation('stars');
    }

    protected function updateRatingStats()
    {
        $this->averageRating = Rating::getAverageRating($this->translationId);
        $this->totalRatings = Rating::getTotalRatings($this->translationId);
    }

    public function submitRating()
    {
        if (!Auth::check()) {
            $this->addError('auth', 'Baholash uchun tizimga kirishingiz kerak.');
            return;
        }

        $this->isSubmitting = true;

        $this->validate([
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000|min:5',
        ], [
            'stars.required' => 'Yulduzcha bahosini tanlang',
            'stars.min' => 'Minimal 1 yulduzcha bering',
            'stars.max' => 'Maksimal 5 yulduzcha berish mumkin',
            'comment.min' => 'Izoh kamida 5 ta belgi bo\'lishi kerak',
            'comment.max' => 'Izoh 1000 ta belgidan oshmasligi kerak',
        ]);

        try {
            // Use updateOrCreate to either create new or update existing rating
            $rating = Rating::updateOrCreate(
                [
                    'translation_id' => $this->translationId,
                    'user_id' => Auth::id(),
                ],
                [
                    'stars' => $this->stars,
                    'comment' => $this->comment,
                    'created_at' => now(),
                ]
            );

            $this->showSuccess = true;
            $this->successMessage = $rating->wasRecentlyCreated
                ? 'Rahmat! Sizning bahoyingiz qo\'shildi.'
                : 'Bahoyingiz muvaffaqiyatli yangilandi!';

            // Update the existingRating property to reflect current state
            $this->existingRating = $rating;

            // Update rating statistics
            $this->updateRatingStats();

            // Notify other components to refresh
            $this->dispatch('rating-submitted');

            // Hide success message after 3 seconds using JavaScript
            $this->dispatch('hide-success-message');

        } catch (\Exception $e) {
            if (str_contains($e->getMessage(), 'unique_user_translation_rating')) {
                $this->addError('duplicate', 'Siz bu tarjimani allaqachon baholan.');
            } else {
                $this->addError('general', 'Baholashda xatolik yuz berdi. Qaytadan urining.');
            }
        } catch (\Exception $e) {
            $this->addError('general', 'Baholashda xatolik yuz berdi. Qaytadan urining.');
        }

        $this->isSubmitting = false;
    }

    public function hideSuccessMessage()
    {
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.rating-form');
    }
}


