<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Validation\Rule;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'translation_id',
        'user_id',
        'stars',
        'comment',
        'created_at',
    ];

    public $timestamps = false;

    protected $casts = [
        'created_at' => 'datetime',
        'stars' => 'integer',
    ];

    /**
     * Validation rules for rating submission
     */
    public static function validationRules($translationId = null, $userId = null)
    {
        return [
            'stars' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string|max:1000|min:5',
            'translation_id' => [
                'required',
                'exists:translations,id',
                $userId ? Rule::unique('ratings')->where(function ($query) use ($translationId, $userId) {
                    return $query->where('translation_id', $translationId)
                                ->where('user_id', $userId);
                }) : 'exists:translations,id'
            ],
        ];
    }

    /**
     * Check if user can rate this translation
     */
    public static function canUserRate($userId, $translationId)
    {
        // Check if user already rated this translation
        $existingRating = static::where('user_id', $userId)
            ->where('translation_id', $translationId)
            ->exists();

        if ($existingRating) {
            return false;
        }

        // Check if user is trying to rate their own translation
        $translation = \App\Models\Translation::find($translationId);
        if ($translation && $translation->translator->user_id === $userId) {
            return false;
        }

        return true;
    }

    /**
     * Get user's existing rating for a translation
     */
    public static function getUserRating($userId, $translationId)
    {
        return static::where('user_id', $userId)
            ->where('translation_id', $translationId)
            ->latest('created_at')  // Get the most recent rating
            ->first();
    }

    /**
     * Calculate average rating for a translation
     */
    public static function getAverageRating($translationId)
    {
        return static::where('translation_id', $translationId)
            ->avg('stars') ?: 0;
    }

    /**
     * Get total ratings count for a translation
     */
    public static function getTotalRatings($translationId)
    {
        return static::where('translation_id', $translationId)
            ->count();
    }

    /**
     * Relationships
     */
    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Accessor for formatted comment with fallback
     */
    public function getFormattedCommentAttribute()
    {
        return $this->comment ?: 'Ajoyib tarjima! Tavsiya qilaman.';
    }

    /**
     * Scope for latest ratings
     */
    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Scope for ratings with users
     */
    public function scopeWithUser($query)
    {
        return $query->with('user:id,name,email');
    }
}
