<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
    ];

    /**
     * Autor teme.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Postovi koji pripadaju temi.
     */
    public function posts()
    {
        return $this->hasMany(Post::class);
    }
}