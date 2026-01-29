<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Upload extends Model
{
    use HasFactory;

    protected $fillable = [
        'translator_id',
        'translation_id',
        'file_path',
    ];

    /**
     * Relationships
     */
    public function translator()
    {
        return $this->belongsTo(TranslatorPortfolio::class, 'translator_id');
    }

    public function translation()
    {
        return $this->belongsTo(Translation::class);
    }
}
