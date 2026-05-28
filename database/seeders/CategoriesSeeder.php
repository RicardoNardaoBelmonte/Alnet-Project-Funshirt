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
            // 1
            [
                'name' => 'Streetwear',
                'image_url' => '/images/categories/streetwear.webp',
            ],
            // 2
            [
                'name' => 'Anime',
                'image_url' => 'https://images.unsplash.com/photo-1614583224978-f05ce51ef5fa?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            // 3
            [
                'name' => 'Team Jerseys',
                'image_url' => 'https://images.unsplash.com/photo-1546519638-68e109498ffc?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            // 4
            [
                'name' => 'Celebrities',
                'image_url' => '/images/categories/celebrities.jpg',
            ],
            // 5
            [
                'name' => 'Basics',
                'image_url' => '/images/categories/basics.jpg',
            ],
            // 6
            [
                'name' => 'Vintage',
                'image_url' => 'https://images.unsplash.com/photo-1558171813-1e46e63e3a14?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            // 7
            [
                'name' => 'Music',
                'image_url' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            // 8
            [
                'name' => 'Sports',
                'image_url' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            // 9
            [
                'name' => 'Gaming',
                'image_url' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=800&h=500&fit=crop&auto=format&q=80',
            ],
            // 10
            [
                'name' => 'Nature',
                'image_url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=800&h=500&fit=crop&auto=format&q=80',
            ],
        ]);

        $this->command->info('Categories seeded successfully');
    }
}
