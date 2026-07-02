<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;

class PostSeeder extends Seeder
{
    public function run(): void
    {
        Post::create(['topic_id' => 1, 'user_id' => 3, 'content' => 'Laravel je odlican za razvoj REST API-ja.']);
        Post::create(['topic_id' => 1, 'user_id' => 4, 'content' => 'Sanctum je praktican za autentifikaciju API korisnika.']);
        Post::create(['topic_id' => 1, 'user_id' => 5, 'content' => 'Route model binding dosta pojednostavljuje kontrolere.']);

        Post::create(['topic_id' => 2, 'user_id' => 4, 'content' => 'PHP 8 donosi dosta korisnih poboljsanja za backend razvoj.']);
        Post::create(['topic_id' => 2, 'user_id' => 3, 'content' => 'Composer je neophodan za rad sa Laravel paketima.']);

        Post::create(['topic_id' => 3, 'user_id' => 5, 'content' => 'React se lepo povezuje sa Laravel REST API-jem.']);
        Post::create(['topic_id' => 3, 'user_id' => 3, 'content' => 'Fetch API je dovoljan za osnovnu komunikaciju sa backendom.']);
    }
}