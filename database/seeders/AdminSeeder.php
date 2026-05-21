<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.test'],
            [
                'name' => 'Admin',
                'password' => Hash::make('password'),
                'admin' => true,
                'type' => 'A',
                'gender' => 'M',
                'photo_url' => null,
            ]
        );

        $this->command->info('Admin user created: admin@example.test / password');
    }
}
