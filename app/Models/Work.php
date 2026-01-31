<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Work extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'original_language_id',
        'author_name',
        'description',
    ];

    /**
     * Relationships
     */
    public function originalLanguage()
    {
        return $this->belongsTo(AvailableLanguage::class, 'original_language_id');
    }

    public function translations()
    {
        return $this->hasMany(Translation::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
