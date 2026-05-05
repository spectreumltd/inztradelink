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
        User::unguarded(function (): void {
            User::updateOrCreate(
                ['email' => 'admin@gmail.com'],
                [
                    'name' => 'Admin',
                    'password' => '$2y$10$.EzIxaQN8BJWWcSJDjeTFOWpRVZkWe2u0XLSF9ugKhqsN2PZwoDv2',
                    'role_id' => User::ADMIN,
                    'is_active' => 1,
                    'email_verified_at' => now(),
                ]
            );
        });
    }
}
