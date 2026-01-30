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

    public function translations()
    {
        return $this->hasMany(Translation::class, 'translator_id');
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
}
