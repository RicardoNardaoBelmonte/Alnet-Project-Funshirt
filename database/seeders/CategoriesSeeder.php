<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->truncate();

        DB::table('categories')->insert([
            [
                'name' => 'Streetwear',
                'image_url' => '/images/categories/streetwear.webp',
            ],
            [
                'name' => 'Anime',
                'image_url' => 'https://images.unsplash.com/photo-1614583224978-f05ce51ef5fa?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            [
                'name' => 'Team Jerseys',
                'image_url' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            [
                'name' => 'Celebrities',
                'image_url' => '/images/categories/celebrities.jpg',
            ],
            [
                'name' => 'Basics',
                'image_url' => '/images/categories/basics.jpg',
            ],
        ]);

        $this->command->info('Categories seeded successfully');
    }
}
