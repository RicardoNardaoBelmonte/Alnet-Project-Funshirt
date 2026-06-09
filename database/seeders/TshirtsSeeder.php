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
            // ── Streetwear ───────────────────────────────────────────────────
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

            // ── Anime ────────────────────────────────────────────────────────
            [
                'category' => 'Anime',
                'name' => 'Anime Hero Tee',
                'description' => 'Inspired by legendary anime warriors. Show your passion for anime culture.',
                'image_url' => 'https://images.unsplash.com/photo-1503341455253-b2e723bb3dbb?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(70),
            ],
            [
                'category' => 'Anime',
                'name' => 'Dragon Print Tee',
                'description' => 'Eye-catching dragon graphic for true anime fans.',
                'image_url' => 'https://images.unsplash.com/photo-1576566588028-4147f3842f27?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(50),
            ],
            [
                'category' => 'Anime',
                'name' => 'Vintage Anime Graphic Tee',
                'description' => 'Retro faded print inspired by classic 90s anime series.',
                'image_url' => 'https://images.unsplash.com/photo-1503342217505-b0a15ec3261c?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(7),
            ],

            // ── Team Jerseys ─────────────────────────────────────────────────
            [
                'category' => 'Team Jerseys',
                'name' => 'Retro Team Jersey Tee',
                'description' => 'Classic football-inspired jersey tee with retro number print.',
                'image_url' => 'https://images.unsplash.com/photo-1529374255-868c7b21e825?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(100),
            ],
            [
                'category' => 'Team Jerseys',
                'name' => 'Champions Edition Tee',
                'description' => 'Celebrate your team with this premium champions edition jersey tee.',
                'image_url' => 'https://images.unsplash.com/photo-1583743814966-8936f5b7be1a?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(3),
            ],

            // ── Celebrities ──────────────────────────────────────────────────
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

            // ── Basics ───────────────────────────────────────────────────────
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

            // ── Vintage ──────────────────────────────────────────────────────
            [
                'category' => 'Vintage',
                'name' => 'Washed Retro Logo Tee',
                'description' => 'Acid-washed tee with a faded 80s logo for that perfect vintage look.',
                'image_url' => 'https://images.unsplash.com/photo-1583744946564-b52d01a7de50?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(55),
            ],
            [
                'category' => 'Vintage',
                'name' => 'Distressed Band Tee',
                'description' => 'Heavy-distressed bootleg band tee — worn-in character from day one.',
                'image_url' => 'https://images.unsplash.com/photo-1562157873-818bc0726f68?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(40),
            ],

            // ── Music ────────────────────────────────────────────────────────
            [
                'category' => 'Music',
                'name' => 'Tour Merch Classic Tee',
                'description' => 'Concert-style tour merch tee with setlist back print.',
                'image_url' => 'https://images.unsplash.com/photo-1511671782779-c97d3d27a1d4?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(65),
            ],
            [
                'category' => 'Music',
                'name' => 'Vinyl Record Graphic Tee',
                'description' => 'Bold vinyl record graphic tee for music lovers.',
                'image_url' => 'https://images.unsplash.com/photo-1470225620780-dba8ba36b745?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(35),
            ],

            // ── Sports ───────────────────────────────────────────────────────
            [
                'category' => 'Sports',
                'name' => 'Athletic Performance Tee',
                'description' => 'Moisture-wicking athletic tee built for training sessions.',
                'image_url' => 'https://images.unsplash.com/photo-1517649763962-0c623066013b?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(75),
            ],
            [
                'category' => 'Sports',
                'name' => 'Marathon Runner Tee',
                'description' => 'Lightweight breathable tee for long-distance runners.',
                'image_url' => 'https://images.unsplash.com/photo-1476480862126-209bfaa8edc8?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(45),
            ],

            // ── Gaming ───────────────────────────────────────────────────────
            [
                'category' => 'Gaming',
                'name' => 'Retro Console Tee',
                'description' => 'Pixelated retro console graphic — a must for classic gamers.',
                'image_url' => 'https://images.unsplash.com/photo-1593305841991-05c297ba4575?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(80),
            ],
            [
                'category' => 'Gaming',
                'name' => 'GG No Re Tee',
                'description' => 'Internet-famous gamer phrase tee — wear your competitive spirit.',
                'image_url' => 'https://images.unsplash.com/photo-1542751371-adc38448a05e?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(50),
            ],

            // ── Nature ───────────────────────────────────────────────────────
            [
                'category' => 'Nature',
                'name' => 'Mountain Peak Tee',
                'description' => 'Minimalist mountain range print for the outdoor adventurer.',
                'image_url' => 'https://images.unsplash.com/photo-1441974231531-c6227db76b6e?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(85),
            ],
            [
                'category' => 'Nature',
                'name' => 'Ocean Wave Tee',
                'description' => 'Watercolour wave print tee inspired by the open sea.',
                'image_url' => 'https://images.unsplash.com/photo-1505118380757-91f5f5632de0?w=600&h=600&fit=crop&auto=format&q=80',
                'created_at' => now()->subDays(60),
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