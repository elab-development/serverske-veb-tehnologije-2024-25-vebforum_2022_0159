<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    public function run(): void
    {
        Comment::create(['post_id' => 1, 'user_id' => 4, 'content' => 'Slazem se, Laravel mnogo ubrzava razvoj.']);
        Comment::create(['post_id' => 1, 'user_id' => 5, 'content' => 'Posebno mi se svidja rad sa migracijama.']);
        Comment::create(['post_id' => 2, 'user_id' => 3, 'content' => 'Sanctum je jednostavniji od Passport-a za ovaj tip projekta.']);
        Comment::create(['post_id' => 3, 'user_id' => 4, 'content' => 'Route model binding je bas koristan.']);
        Comment::create(['post_id' => 4, 'user_id' => 5, 'content' => 'PHP 8 je dosta modernizovao jezik.']);
        Comment::create(['post_id' => 6, 'user_id' => 3, 'content' => 'React i Laravel su dobra kombinacija.']);
    }
}