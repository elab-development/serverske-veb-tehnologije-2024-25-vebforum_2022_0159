<?php

namespace Database\Seeders;

use App\Models\Like;
use Illuminate\Database\Seeder;

class LikeSeeder extends Seeder
{
    public function run(): void
    {
        $likes = [
            [3, 1], [4, 1], [5, 1],
            [3, 2], [5, 2],
            [4, 3],
            [3, 4], [5, 4],
            [4, 6], [3, 6],
            [5, 7],
        ];

        foreach ($likes as [$userId, $postId]) {
            Like::firstOrCreate([
                'user_id' => $userId,
                'post_id' => $postId,
            ]);
        }
    }
}