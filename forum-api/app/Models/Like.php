<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Like extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'user_id',
    ];

    /**
     * Post koji je lajkovan.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Korisnik koji je lajkovao post.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}