<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TshirtsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tshirt_images')->truncate();

        // Build a name→id lookup for categories
        $catIds = Category::pluck('id', 'name');

        $tshirts = [
            [
                'category' => 'Streetwear',
                'name' => 'Urban Graffiti Tee',
                'description' => 'Oversized black tee with a raw graffiti-print chest graphic.',
                'image_url' => '/images/tshirts/streetwear-1.jpg',
                'created_at' => now()->subDays(90),
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Jordan Legacy Tee',
                'description' => '"Jordan 23 Dream" oversized black tee — a tribute to the G.O.A.T.',
                'image_url' => '/images/tshirts/streetwear-2.webp',
                'created_at' => now()->subDays(80),
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Street Vibes Duo Tee',
                'description' => 'Iconic monster-face graphic available in black and white.',
                'image_url' => '/images/tshirts/streetwear-3.jpg',
                'created_at' => now()->subDays(60),
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Dark Drop Logo Tee',
                'description' => 'Clean dark charcoal tee with a subtle embroidered chest logo.',
                'image_url' => '/images/tshirts/streetwear-4.webp',
                'created_at' => now()->subDays(45),
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Legends Montage Tee',
                'description' => 'Black tee featuring a painted montage of hip-hop legends.',
                'image_url' => '/images/tshirts/streetwear-5.webp',
                'created_at' => now()->subDays(10),
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Azul Oriente Tee',
                'description' => 'Vibrant streetwear tee in a bold oriental blue colourway.',
                'image_url' => '/images/tshirts/streetwear-6.avif',
                'created_at' => now()->subDays(5),
            ],
            [
                'category' => 'Celebrities',
                'name' => 'Rihanna Tribute Tee',
                'description' => 'Bold bootleg-style Rihanna graphic tee — a pop culture statement.',
                'image_url' => '/images/tshirts/celebrities-1.jpg',
                'created_at' => now()->subDays(30),
            ],
            [
                'category' => 'Celebrities',
                'name' => 'MC Kevin Tribute Tee',
                'description' => 'Tribute to MC Kevin with a vibrant vintage-style montage print.',
                'image_url' => '/images/tshirts/celebrities-2.jpg',
                'created_at' => now()->subDays(25),
            ],
            [
                'category' => 'Celebrities',
                'name' => 'Chico Rey Bootleg Tee',
                'description' => 'Vintage-washed bootleg tee paying homage to Chico Rey.',
                'image_url' => '/images/tshirts/celebrities-3.jpg',
                'created_at' => now()->subDays(20),
            ],
            [
                'category' => 'Celebrities',
                'name' => 'Matuê Bootleg Tee',
                'description' => 'Street-style tribute tee featuring Matuê in a classic bootleg format.',
                'image_url' => '/images/tshirts/celebrities-4.jpg',
                'created_at' => now()->subDays(4),
            ],
            [
                'category' => 'Basics',
                'name' => 'Quiksilver Classic Tee',
                'description' => 'Clean Quiksilver logo tee in a timeless navy — an everyday essential.',
                'image_url' => '/images/tshirts/basics-1.jpg',
                'created_at' => now()->subDays(15),
            ],
            [
                'category' => 'Basics',
                'name' => 'Essential Pack Tee',
                'description' => 'Soft-touch crew-neck tee available in black, grey, and white.',
                'image_url' => '/images/tshirts/basics-2.jpg',
                'created_at' => now()->subDays(12),
            ],
            [
                'category' => 'Basics',
                'name' => 'Jack & Jones Archive Tee',
                'description' => 'Minimalist Jack & Jones Archive logo tee in sage green.',
                'image_url' => '/images/tshirts/basics-3.jpg',
                'created_at' => now()->subDays(8),
            ],
        ];

        foreach ($tshirts as $data) {
            $categoryName = $data['category'];
            unset($data['category']);

            $data['category_id'] = $catIds[$categoryName] ?? null;
            $data['updated_at'] = $data['created_at'];

            DB::table('tshirt_images')->insert($data);
        }

        $this->command->info('T-shirt images seeded successfully');
    }
}