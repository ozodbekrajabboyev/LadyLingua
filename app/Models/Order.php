<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'translator_id',
        'work_id',
        'language_id',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'datetime',
    ];

    /**
     * Relationships
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function translator()
    {
        return $this->belongsTo(TranslatorPortfolio::class, 'translator_id');
    }

    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function language()
    {
        return $this->belongsTo(AvailableLanguage::class, 'language_id');
    }

    /**
     * Get the related translation if exists - proper Eloquent relationship
     */
    public function translation()
    {
        return $this->hasOne(Translation::class, 'work_id', 'work_id')
            ->where('translator_id', $this->translator_id)
            ->where('language_id', $this->language_id);
    }

    /**
     * Get the related translation (helper method)
     */
    public function getTranslation()
    {
        return Translation::where('work_id', $this->work_id)
            ->where('translator_id', $this->translator_id)
            ->where('language_id', $this->language_id)
            ->first();
    }
}
