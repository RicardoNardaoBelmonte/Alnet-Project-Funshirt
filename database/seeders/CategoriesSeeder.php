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
