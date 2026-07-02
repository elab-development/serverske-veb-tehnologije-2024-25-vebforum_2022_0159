<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'username' => 'admin',
            'email' => 'admin@forum.test',
            'password' => 'password123',
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Moderator',
            'username' => 'moderator',
            'email' => 'moderator@forum.test',
            'password' => 'password123',
            'role' => 'moderator',
        ]);

        User::create([
            'name' => 'Marko Markovic',
            'username' => 'marko',
            'email' => 'marko@forum.test',
            'password' => 'password123',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Milica Petrovic',
            'username' => 'milica',
            'email' => 'milica@forum.test',
            'password' => 'password123',
            'role' => 'user',
        ]);

        User::create([
            'name' => 'Nikola Jovanovic',
            'username' => 'nikola',
            'email' => 'nikola@forum.test',
            'password' => 'password123',
            'role' => 'user',
        ]);
    }
}