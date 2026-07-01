<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'post_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
    ];

    /**
     * Post kome attachment pripada.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }
}