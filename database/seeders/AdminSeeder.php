<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::firstOrCreate(
            ['email' => 'admin@example.test'],
            [
                'name'              => 'Admin',
                'password'          => Hash::make('password'),
                'user_type'         => 'A',
                'gender'            => 'M',
                'blocked'           => 0,
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created: admin@example.test / password');
    }
}