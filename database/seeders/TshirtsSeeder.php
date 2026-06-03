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
            // ── Streetwear ───────────────────────────────────────────────────
            [
                'category' => 'Streetwear',
                'name' => 'Urban Graffiti Tee',
                'description' => 'Oversized black tee with a raw graffiti-print chest graphic.',
                'image_url' => '/images/tshirts/streetwear-1.jpg',
                'price' => 29.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(90),
                'colors' => ['Black', 'White', 'Red'],
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Jordan Legacy Tee',
                'description' => '"Jordan 23 Dream" oversized black tee — a tribute to the G.O.A.T.',
                'image_url' => '/images/tshirts/streetwear-2.webp',
                'price' => 34.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(80),
                'colors' => ['Black', 'White'],
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Street Vibes Duo Tee',
                'description' => 'Iconic monster-face graphic available in black and white.',
                'image_url' => '/images/tshirts/streetwear-3.jpg',
                'price' => 27.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(60),
                'colors' => ['Black', 'White'],
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Dark Drop Logo Tee',
                'description' => 'Clean dark charcoal tee with a subtle embroidered chest logo.',
                'image_url' => '/images/tshirts/streetwear-4.webp',
                'price' => 32.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(45),
                'colors' => ['Black', 'Navy'],
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Legends Montage Tee',
                'description' => 'Black tee featuring a painted montage of hip-hop legends.',
                'image_url' => '/images/tshirts/streetwear-5.webp',
                'price' => 39.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(10),
                'colors' => ['Black'],
            ],
            [
                'category' => 'Streetwear',
                'name' => 'Azul Oriente Tee',
                'description' => 'Vibrant streetwear tee in a bold oriental blue colourway.',
                'image_url' => '/images/tshirts/streetwear-6.avif',
                'price' => 31.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(5),
                'colors' => ['Blue', 'Navy'],
            ],

            // ── Anime ────────────────────────────────────────────────────────
            [
                'category' => 'Anime',
                'name' => 'Anime Hero Tee',
                'description' => 'Inspired by legendary anime warriors. Show your passion for anime culture.',
                'image_url' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 34.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(70),
                'colors' => ['Black', 'Red', 'Purple'],
            ],
            [
                'category' => 'Anime',
                'name' => 'Dragon Print Tee',
                'description' => 'Eye-catching dragon graphic for true anime fans.',
                'image_url' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 37.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(50),
                'colors' => ['Black', 'Blue', 'Navy'],
            ],
            [
                'category' => 'Anime',
                'name' => 'Vintage Anime Graphic Tee',
                'description' => 'Retro faded print inspired by classic 90s anime series.',
                'image_url' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 31.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(7),
                'colors' => ['White', 'Orange', 'Pink'],
            ],

            // ── Team Jerseys ─────────────────────────────────────────────────
            [
                'category' => 'Team Jerseys',
                'name' => 'Retro Team Jersey Tee',
                'description' => 'Classic football-inspired jersey tee with retro number print.',
                'image_url' => 'https://images.unsplash.com/photo-1529374255-868c7b21e825?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 39.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(100),
                'colors' => ['White', 'Blue', 'Navy'],
            ],
            [
                'category' => 'Team Jerseys',
                'name' => 'Champions Edition Tee',
                'description' => 'Celebrate your team with this premium champions edition jersey tee.',
                'image_url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 44.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(3),
                'colors' => ['Black', 'Red', 'Green'],
            ],

            // ── Celebrities ──────────────────────────────────────────────────
            [
                'category' => 'Celebrities',
                'name' => 'Rihanna Tribute Tee',
                'description' => 'Bold bootleg-style Rihanna graphic tee — a pop culture statement.',
                'image_url' => '/images/tshirts/celebrities-1.jpg',
                'price' => 44.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(30),
                'colors' => ['Black', 'Red', 'Purple'],
            ],
            [
                'category' => 'Celebrities',
                'name' => 'MC Kevin Tribute Tee',
                'description' => 'Tribute to MC Kevin with a vibrant vintage-style montage print.',
                'image_url' => '/images/tshirts/celebrities-2.jpg',
                'price' => 42.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(25),
                'colors' => ['Black', 'Yellow'],
            ],
            [
                'category' => 'Celebrities',
                'name' => 'Chico Rey Bootleg Tee',
                'description' => 'Vintage-washed bootleg tee paying homage to Chico Rey.',
                'image_url' => '/images/tshirts/celebrities-3.jpg',
                'price' => 38.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(20),
                'colors' => ['Black', 'White'],
            ],
            [
                'category' => 'Celebrities',
                'name' => 'Matuê Bootleg Tee',
                'description' => 'Street-style tribute tee featuring Matuê in a classic bootleg format.',
                'image_url' => '/images/tshirts/celebrities-4.jpg',
                'price' => 41.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(4),
                'colors' => ['Black', 'White', 'Red'],
            ],

            // ── Basics ───────────────────────────────────────────────────────
            [
                'category' => 'Basics',
                'name' => 'Quiksilver Classic Tee',
                'description' => 'Clean Quiksilver logo tee in a timeless navy — an everyday essential.',
                'image_url' => '/images/tshirts/basics-1.jpg',
                'price' => 22.99,
                'sales_count' => rand(50, 300),
                'created_at' => now()->subDays(15),
                'colors' => ['Navy', 'White', 'Black'],
            ],
            [
                'category' => 'Basics',
                'name' => 'Essential Pack Tee',
                'description' => 'Soft-touch crew-neck tee available in black, grey, and white.',
                'image_url' => '/images/tshirts/basics-2.jpg',
                'price' => 19.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(12),
                'colors' => ['Black', 'White'],
            ],
            [
                'category' => 'Basics',
                'name' => 'Jack & Jones Archive Tee',
                'description' => 'Minimalist Jack & Jones Archive logo tee in sage green.',
                'image_url' => '/images/tshirts/basics-3.jpg',
                'price' => 24.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(8),
                'colors' => ['Green', 'White', 'Black'],
            ],
            [
                'category' => 'Basics',
                'name' => 'Patagonia Sport Tee',
                'description' => 'Lightweight Patagonia tee in steel blue — perfect for any occasion.',
                'image_url' => '/images/tshirts/basics-4.webp',
                'price' => 34.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(6),
                'colors' => ['Blue', 'Navy'],
            ],
            [
                'category' => 'Basics',
                'name' => 'Military Green Basic Tee',
                'description' => 'Relaxed-fit military green tee — a wardrobe staple.',
                'image_url' => '/images/tshirts/basics-5.webp',
                'price' => 21.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(4),
                'colors' => ['Green', 'Black', 'White'],
            ],
            [
                'category' => 'Basics',
                'name' => 'Slim Fit Essential Tee',
                'description' => 'Slim-fit premium cotton tee in classic neutral tones.',
                'image_url' => '/images/tshirts/basics-6.webp',
                'price' => 23.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(2),
                'colors' => ['Black', 'White', 'Navy'],
            ],
            [
                'category' => 'Basics',
                'name' => 'Relaxed Cotton Tee',
                'description' => 'Ultra-soft relaxed-fit tee for everyday comfort.',
                'image_url' => '/images/tshirts/basics-7.webp',
                'price' => 20.99,
                'sales_count' => rand(0, 49),
                'created_at' => now()->subDays(1),
                'colors' => ['White', 'Black', 'Blue'],
            ],

            // ── Vintage ──────────────────────────────────────────────────────
            [
                'category' => 'Vintage',
                'name' => 'Washed Retro Logo Tee',
                'description' => 'Acid-washed tee with a faded 80s logo for that perfect vintage look.',
                'image_url' => 'https://images.unsplash.com/photo-1583744946564-b52d01a7de50?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 33.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(55),
                'colors' => ['Black', 'White', 'Orange'],
            ],
            [
                'category' => 'Vintage',
                'name' => 'Distressed Band Tee',
                'description' => 'Heavy-distressed bootleg band tee — worn-in character from day one.',
                'image_url' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 29.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(40),
                'colors' => ['Black', 'Pink'],
            ],
            [
                'category' => 'Vintage',
                'name' => 'Flea Market Find Tee',
                'description' => 'Oversized vintage-style tee that looks like it was thrifted.',
                'image_url' => 'https://images.unsplash.com/photo-1523381210434-271e8be1f52b?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 27.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(20),
                'colors' => ['Orange', 'White', 'Black'],
            ],

            // ── Music ────────────────────────────────────────────────────────
            [
                'category' => 'Music',
                'name' => 'Tour Merch Classic Tee',
                'description' => 'Concert-style tour merch tee with setlist back print.',
                'image_url' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 36.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(65),
                'colors' => ['Black', 'White'],
            ],
            [
                'category' => 'Music',
                'name' => 'Vinyl Record Graphic Tee',
                'description' => 'Bold vinyl record graphic tee for music lovers.',
                'image_url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 31.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(35),
                'colors' => ['Black', 'Blue', 'Purple'],
            ],
            [
                'category' => 'Music',
                'name' => 'Hip-Hop Culture Tee',
                'description' => 'A tribute to the golden era of hip-hop — boombox and all.',
                'image_url' => 'https://images.unsplash.com/photo-1493225457124-a3eb161ffa5f?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 34.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(15),
                'colors' => ['Black', 'Red'],
            ],

            // ── Sports ───────────────────────────────────────────────────────
            [
                'category' => 'Sports',
                'name' => 'Athletic Performance Tee',
                'description' => 'Moisture-wicking athletic tee built for training sessions.',
                'image_url' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 38.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(75),
                'colors' => ['Black', 'White', 'Blue', 'Green'],
            ],
            [
                'category' => 'Sports',
                'name' => 'Marathon Runner Tee',
                'description' => 'Lightweight breathable tee for long-distance runners.',
                'image_url' => 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 32.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(45),
                'colors' => ['White', 'Blue', 'Purple'],
            ],
            [
                'category' => 'Sports',
                'name' => 'Gym Grind Tee',
                'description' => 'Cut-off inspired gym tee with motivational chest text.',
                'image_url' => 'https://images.unsplash.com/photo-1571019614242-c5c5dee9f50b?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 27.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(10),
                'colors' => ['Black', 'Navy'],
            ],

            // ── Gaming ───────────────────────────────────────────────────────
            [
                'category' => 'Gaming',
                'name' => 'Retro Console Tee',
                'description' => 'Pixelated retro console graphic — a must for classic gamers.',
                'image_url' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 30.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(80),
                'colors' => ['Black', 'Red', 'Purple'],
            ],
            [
                'category' => 'Gaming',
                'name' => 'GG No Re Tee',
                'description' => 'Internet-famous gamer phrase tee — wear your competitive spirit.',
                'image_url' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 27.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(50),
                'colors' => ['Black', 'White', 'Blue'],
            ],
            [
                'category' => 'Gaming',
                'name' => 'Level Up Graphic Tee',
                'description' => 'Bold "Level Up" pixel art tee for the dedicated grinder.',
                'image_url' => 'https://images.unsplash.com/photo-1600861194942-f883de0dfe96?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 29.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(5),
                'colors' => ['Black', 'Pink', 'Blue'],
            ],

            // ── Nature ───────────────────────────────────────────────────────
            [
                'category' => 'Nature',
                'name' => 'Mountain Peak Tee',
                'description' => 'Minimalist mountain range print for the outdoor adventurer.',
                'image_url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 28.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(85),
                'colors' => ['Green', 'Blue', 'White'],
            ],
            [
                'category' => 'Nature',
                'name' => 'Ocean Wave Tee',
                'description' => 'Watercolour wave print tee inspired by the open sea.',
                'image_url' => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 31.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(60),
                'colors' => ['Blue', 'Navy', 'White'],
            ],
            [
                'category' => 'Nature',
                'name' => 'Forest Spirit Tee',
                'description' => 'Botanical print tee featuring lush forest illustration.',
                'image_url' => 'https://images.unsplash.com/photo-1448375240586-882707db888b?w=600&h=600&fit=crop&auto=format&q=80',
                'price' => 29.99,
                'sales_count' => rand(0, 300),
                'created_at' => now()->subDays(25),
                'colors' => ['Green', 'White', 'Black'],
            ],
        ];

        foreach ($tshirts as $data) {
            $colors = $data['colors'];
            unset($data['colors']);
            $data['updated_at'] = $data['created_at'];

            $id = DB::table('tshirts')->insertGetId($data);

            foreach ($colors as $colorName) {
                DB::table('tshirt_color')->insert([
                    'tshirt_id' => $id,
                    'color' => $colorName,
                ]);
            }
        }

        $this->command->info('Tshirts seeded successfully');
    }
}
