<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'translation_id',
        'user_id',
        'stars',
        'comment',
    ];

    public $timestamps = false;
    protected $dates = ['created_at'];

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
}
