<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $databaseType = DB::getConfig('driver');

        $this->command->line(
            'Running seeders for '.$databaseType.' database'
        );

        // Disable FK checks
        if ($databaseType === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = OFF;');
        } else {
            DB::statement('SET foreign_key_checks=0');
        }

        /*
        |--------------------------------------------------------------------------
        | ACADEMIC PROJECT SEEDERS (DISABLED TEMPORARILY)
        |--------------------------------------------------------------------------
        |
        | Uncomment later if needed
        |
        */

        // $this->call(CursosSeeder::class);
        // $this->call(DisciplinasSeeder::class);
        // $this->call(DepartamentosSeeder::class);
        // $this->call(UsersSeeder::class);
        // $this->call(GradesSeeder::class);

        /*
        |--------------------------------------------------------------------------
        | E-COMMERCE SEEDERS
        |--------------------------------------------------------------------------
        */

        $this->call([
            AdminSeeder::class,
            CategoriesSeeder::class,
            ColorsSeeder::class,
            TshirtsSeeder::class,
        ]);

        // Enable FK checks
        if ($databaseType === 'sqlite') {
            DB::statement('PRAGMA foreign_keys = ON;');
        } else {
            DB::statement('SET foreign_key_checks=1');
        }

        $this->command->info('Database seeded successfully!');
    }
}
