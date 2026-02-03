<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Translation extends Model
{
    use HasFactory;

    protected $fillable = [
        'work_id',
        'translator_id',
        'language_id',
        'status',
        'price',
        'upload_id',
        'preview_pages_cnt',
        'preview_pdf_path',
        'full_pdf_path',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    /**
     * Relationships
     */
    public function work()
    {
        return $this->belongsTo(Work::class);
    }

    public function translator()
    {
        return $this->belongsTo(TranslatorPortfolio::class, 'translator_id');
    }

    public function language()
    {
        return $this->belongsTo(AvailableLanguage::class, 'language_id');
    }

    public function upload()
    {
        return $this->belongsTo(Upload::class);
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
