<?php

namespace Database\Seeders;

use App\Models\Attachment;
use Illuminate\Database\Seeder;

class AttachmentSeeder extends Seeder
{
    public function run(): void
    {
        Attachment::create([
            'post_id' => 1,
            'file_name' => 'laravel-guide.pdf',
            'file_path' => 'attachments/laravel-guide.pdf',
            'file_type' => 'application/pdf',
            'file_size' => 512000,
        ]);

        Attachment::create([
            'post_id' => 3,
            'file_name' => 'mvc-diagram.png',
            'file_path' => 'attachments/mvc-diagram.png',
            'file_type' => 'image/png',
            'file_size' => 256000,
        ]);
    }
}