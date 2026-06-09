<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ColorsSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('colors')->truncate();

        // code = CSS color value (also the base t-shirt image filename in tshirt_base/)
        DB::table('colors')->insert([
            ['code' => 'black',  'name' => 'Black'],
            ['code' => 'white',  'name' => 'White'],
            ['code' => 'red',    'name' => 'Red'],
            ['code' => 'blue',   'name' => 'Blue'],
            ['code' => 'green',  'name' => 'Green'],
            ['code' => 'yellow', 'name' => 'Yellow'],
            ['code' => 'orange', 'name' => 'Orange'],
            ['code' => 'purple', 'name' => 'Purple'],
            ['code' => 'pink',   'name' => 'Pink'],
            ['code' => 'navy',   'name' => 'Navy Blue'],
        ]);

        $this->command->info('Colors seeded successfully');
    }
}