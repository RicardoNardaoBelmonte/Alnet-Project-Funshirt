<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('colors')->truncate();

        DB::table('colors')->insert([
            ['name' => 'Black',  'code' => '#1a1a1a'],
            ['name' => 'White',  'code' => '#ffffff'],
            ['name' => 'Red',    'code' => '#e53e3e'],
            ['name' => 'Blue',   'code' => '#3182ce'],
            ['name' => 'Green',  'code' => '#38a169'],
            ['name' => 'Yellow', 'code' => '#d69e2e'],
            ['name' => 'Orange', 'code' => '#dd6b20'],
            ['name' => 'Purple', 'code' => '#805ad5'],
            ['name' => 'Pink',   'code' => '#d53f8c'],
            ['name' => 'Navy',   'code' => '#2c5282'],
        ]);

        $this->command->info('Colors seeded successfully');
    }
}
