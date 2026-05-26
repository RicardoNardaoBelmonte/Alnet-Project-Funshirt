<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TshirtsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('tshirt_color')->truncate();
        DB::table('tshirts')->truncate();

        $tshirts = [
            // ── Streetwear (category 1) ──────────────────────────────────────
            [
                'category_id' => 1,
                'name' => 'Urban Graffiti Tee',
                'description' => 'Oversized black tee with a raw graffiti-print chest graphic.',
                'image_url' => '/images/tshirts/streetwear-1.jpg',
                'price' => 29.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(90),
                'colors' => [1, 2, 3],
            ],
            [
                'category_id' => 1,
                'name' => 'Jordan Legacy Tee',
                'description' => '"Jordan 23 Dream" oversized black tee — a tribute to the G.O.A.T.',
                'image_url' => '/images/tshirts/streetwear-2.webp',
                'price' => 34.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(80),
                'colors' => [1, 2],
            ],
            [
                'category_id' => 1,
                'name' => 'Street Vibes Duo Tee',
                'description' => 'Iconic monster-face graphic available in black and white.',
                'image_url' => '/images/tshirts/streetwear-3.jpg',
                'price' => 27.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(60),
                'colors' => [1, 2],
            ],
            [
                'category_id' => 1,
                'name' => 'Dark Drop Logo Tee',
                'description' => 'Clean dark charcoal tee with a subtle embroidered chest logo.',
                'image_url' => '/images/tshirts/streetwear-4.webp',
                'price' => 32.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(45),
                'colors' => [1, 10],
            ],
            [
                'category_id' => 1,
                'name' => 'Legends Montage Tee',
                'description' => 'Black tee featuring a painted montage of hip-hop legends.',
                'image_url' => '/images/tshirts/streetwear-5.webp',
                'price' => 39.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(10),
                'colors' => [1],
            ],
            [
                'category_id' => 1,
                'name' => 'Azul Oriente Tee',
                'description' => 'Vibrant streetwear tee in a bold oriental blue colourway.',
                'image_url' => '/images/tshirts/streetwear-6.avif',
                'price' => 31.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(5),
                'colors' => [4, 10],
            ],

            // ── Anime (category 2) ───────────────────────────────────────────
            [
                'category_id' => 2,
                'name' => 'Anime Hero Tee',
                'description' => 'Inspired by legendary anime warriors. Show your passion for anime culture.',
                'image_url' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 34.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(70),
                'colors' => [1, 3, 8],
            ],
            [
                'category_id' => 2,
                'name' => 'Dragon Print Tee',
                'description' => 'Eye-catching dragon graphic for true anime fans.',
                'image_url' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 37.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(50),
                'colors' => [1, 4, 10],
            ],
            [
                'category_id' => 2,
                'name' => 'Vintage Anime Graphic Tee',
                'description' => 'Retro faded print inspired by classic 90s anime series.',
                'image_url' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 31.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(7),
                'colors' => [2, 7, 9],
            ],

            // ── Team Jerseys (category 3) ────────────────────────────────────
            [
                'category_id' => 3,
                'name' => 'Retro Team Jersey Tee',
                'description' => 'Classic football-inspired jersey tee with retro number print.',
                'image_url' => 'https://images.unsplash.com/photo-1529374255-868c7b21e825?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 39.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(100),
                'colors' => [2, 4, 10],
            ],
            [
                'category_id' => 3,
                'name' => 'Champions Edition Tee',
                'description' => 'Celebrate your team with this premium champions edition jersey tee.',
                'image_url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 44.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(3),
                'colors' => [1, 3, 5],
            ],

            // ── Celebrities (category 4) ─────────────────────────────────────
            [
                'category_id' => 4,
                'name' => 'Rihanna Tribute Tee',
                'description' => 'Bold bootleg-style Rihanna graphic tee — a pop culture statement.',
                'image_url' => '/images/tshirts/celebrities-1.jpg',
                'price' => 44.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(30),
                'colors' => [1, 3, 8],
            ],
            [
                'category_id' => 4,
                'name' => 'MC Kevin Tribute Tee',
                'description' => 'Tribute to MC Kevin with a vibrant vintage-style montage print.',
                'image_url' => '/images/tshirts/celebrities-2.jpg',
                'price' => 42.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(25),
                'colors' => [1, 6],
            ],
            [
                'category_id' => 4,
                'name' => 'Chico Rey Bootleg Tee',
                'description' => 'Vintage-washed bootleg tee paying homage to Chico Rey.',
                'image_url' => '/images/tshirts/celebrities-3.jpg',
                'price' => 38.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(20),
                'colors' => [1, 2],
            ],
            [
                'category_id' => 4,
                'name' => 'Matuê Bootleg Tee',
                'description' => 'Street-style tribute tee featuring Matuê in a classic bootleg format.',
                'image_url' => '/images/tshirts/celebrities-4.jpg',
                'price' => 41.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(4),
                'colors' => [1, 2, 3],
            ],

            // ── Basics (category 5) ──────────────────────────────────────────
            [
                'category_id' => 5,
                'name' => 'Quiksilver Classic Tee',
                'description' => 'Clean Quiksilver logo tee in a timeless navy — an everyday essential.',
                'image_url' => '/images/tshirts/basics-1.jpg',
                'price' => 22.99,
                'is_best_seller' => true,
                'created_at' => now()->subDays(15),
                'colors' => [10, 2, 1],
            ],
            [
                'category_id' => 5,
                'name' => 'Essential Pack Tee',
                'description' => 'Soft-touch crew-neck tee available in black, grey, and white.',
                'image_url' => '/images/tshirts/basics-2.jpg',
                'price' => 19.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(12),
                'colors' => [1, 2],
            ],
            [
                'category_id' => 5,
                'name' => 'Jack & Jones Archive Tee',
                'description' => 'Minimalist Jack & Jones Archive logo tee in sage green.',
                'image_url' => '/images/tshirts/basics-3.jpg',
                'price' => 24.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(8),
                'colors' => [5, 2, 1],
            ],
            [
                'category_id' => 5,
                'name' => 'Patagonia Sport Tee',
                'description' => 'Lightweight Patagonia tee in steel blue — perfect for any occasion.',
                'image_url' => '/images/tshirts/basics-4.webp',
                'price' => 34.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(6),
                'colors' => [4, 10],
            ],
            [
                'category_id' => 5,
                'name' => 'Military Green Basic Tee',
                'description' => 'Relaxed-fit military green tee — a wardrobe staple.',
                'image_url' => '/images/tshirts/basics-5.webp',
                'price' => 21.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(4),
                'colors' => [5, 1, 2],
            ],
            [
                'category_id' => 5,
                'name' => 'Slim Fit Essential Tee',
                'description' => 'Slim-fit premium cotton tee in classic neutral tones.',
                'image_url' => '/images/tshirts/basics-6.webp',
                'price' => 23.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(2),
                'colors' => [1, 2, 10],
            ],
            [
                'category_id' => 5,
                'name' => 'Relaxed Cotton Tee',
                'description' => 'Ultra-soft relaxed-fit tee for everyday comfort.',
                'image_url' => '/images/tshirts/basics-7.webp',
                'price' => 20.99,
                'is_best_seller' => false,
                'created_at' => now()->subDays(1),
                'colors' => [2, 1, 4],
            ],
        ];

        foreach ($tshirts as $data) {
            $colors = $data['colors'];
            unset($data['colors']);
            $data['updated_at'] = $data['created_at'];

            $id = DB::table('tshirts')->insertGetId($data);

            foreach ($colors as $colorId) {
                DB::table('tshirt_color')->insert([
                    'tshirt_id' => $id,
                    'color_id' => $colorId,
                ]);
            }
        }

        $this->command->info('Tshirts seeded successfully');
    }
}
