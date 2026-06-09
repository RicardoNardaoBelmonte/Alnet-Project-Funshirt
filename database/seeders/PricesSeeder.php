<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricesSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('prices')->truncate();

        DB::table('prices')->insert([
            'unit_price_catalog' => 25.00,
            'unit_price_own' => 15.00,
            'unit_price_catalog_discount' => 20.00,
            'unit_price_own_discount' => 12.00,
            'qty_discount' => 10,
        ]);

        $this->command->info('Prices seeded successfully');
    }
}