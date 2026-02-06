<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TranslatorPortfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'bio',
        'profile_image_url',
        'total_earnings',
        'average_rating',
    ];

    protected $casts = [
        'total_earnings' => 'decimal:2',
        'average_rating' => 'decimal:2',
    ];

    public $timestamps = false;

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function languages()
    {
        return $this->belongsToMany(
            AvailableLanguage::class,
            'translator_language',
            'translator_portfolio_id',
            'available_language_id'
        )->withPivot('proficiency_level')->withTimestamps();
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'translator_id');
    }

    public function ratings()
    {
        return $this->hasManyThrough(
            Rating::class,
            Translation::class,
            'translator_id',
            'translation_id',
            'id',
            'id'
        );
    }

    public function getAverageRatingAttribute(): float
    {
        // Use the ratings() hasManyThrough relationship
        // and explicitly ask for the average of the specific column 'stars'
        return (float) ($this->ratings()->avg('ratings.stars') ?? 0.0);
    }

    public function uploads()
    {
        return $this->hasMany(Upload::class, 'translator_id');
    }
    public function orders()
    {
        return $this->hasMany(Order::class, 'translator_id');
    }
    public function completedProjects()
    {
        return $this->orders()->where('status', 'completed');
    }
    public function completedTranslations()
    {
        return $this->hasMany(Translation::class, 'translator_id')
            ->where('status', 'published');
    }
}
