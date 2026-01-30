<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AvailableLanguage extends Model
{
    use HasFactory;

    protected $fillable = [
        'lang_name',
    ];

    public $timestamps = false;

    /**
     * Relationships
     */
    public function works()
    {
        return $this->hasMany(Work::class, 'original_language_id');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class, 'language_id');
    }
    public function translators()
    {
        return $this->belongsToMany(
            TranslatorPortfolio::class,
            'translator_language',
            'available_language_id',
            'translator_portfolio_id'
        )->withPivot('proficiency_level')->withTimestamps();
    }


    public function orders()
    {
        return $this->hasMany(Order::class, 'language_id');
    }
}
