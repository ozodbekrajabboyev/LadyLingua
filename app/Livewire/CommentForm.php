<?php

namespace App\Livewire;

use App\Models\Comment;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class CommentForm extends Component
{
    public $translationId;
    public $content = '';
    public $isSubmitting = false;
    public $showSuccess = false;

    protected $listeners = ['refreshComments' => '$refresh'];

    public function mount($translationId)
    {
        $this->translationId = $translationId;
    }

    public function submitComment()
    {
        if (!Auth::check()) {
            $this->addError('auth', 'Izoh qoldirish uchun tizimga kirishingiz kerak.');
            return;
        }

        $this->isSubmitting = true;

        $this->validate([
            'content' => 'required|string|min:5|max:1000',
        ], [
            'content.required' => 'Izohni kiriting',
            'content.min' => 'Izoh kamida 5 ta belgi bo\'lishi kerak',
            'content.max' => 'Izoh 1000 ta belgidan oshmasligi kerak',
        ]);

        try {
            Comment::create([
                'translation_id' => $this->translationId,
                'user_id' => Auth::id(),
                'content' => $this->content,
            ]);

            $this->content = ''; // Clear the form
            $this->showSuccess = true;

            // Notify other components to refresh
            $this->dispatch('comment-submitted');

        } catch (\Exception $e) {
            $this->addError('general', 'Izoh yuborishda xatolik yuz berdi. Qaytadan urining.');
        }

        $this->isSubmitting = false;
    }

    public function hideSuccessMessage()
    {
        $this->showSuccess = false;
    }

    public function render()
    {
        return view('livewire.comment-form');
    }
}

