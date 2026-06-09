<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $driver = DB::getConfig('driver');

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET foreign_key_checks=0');
        }

        $this->call([
            AdminSeeder::class,
            CategoriesSeeder::class,
            ColorsSeeder::class,
            PricesSeeder::class,
            TshirtsSeeder::class,
        ]);

        if ($driver === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET foreign_key_checks=1');
        }

        $this->command->info('Database seeded successfully!');
    }
}