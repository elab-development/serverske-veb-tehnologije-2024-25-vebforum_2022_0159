<?php

namespace Database\Seeders;

use App\Models\Topic;
use Illuminate\Database\Seeder;

class TopicSeeder extends Seeder
{
    public function run(): void
    {
        Topic::create([
            'user_id' => 3,
            'title' => 'Laravel framework',
            'description' => 'Diskusija o Laravel framework-u, REST API rutama i MVC arhitekturi.',
        ]);

        Topic::create([
            'user_id' => 4,
            'title' => 'PHP i backend razvoj',
            'description' => 'Tema za pitanja o PHP jeziku, Composer-u i serverskim tehnologijama.',
        ]);

        Topic::create([
            'user_id' => 5,
            'title' => 'JavaScript za frontend',
            'description' => 'Razmena saveta o JavaScript-u, React-u i radu sa API servisima.',
        ]);
    }
}