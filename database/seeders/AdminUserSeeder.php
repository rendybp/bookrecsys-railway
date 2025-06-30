<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'member_id' => 'ADM001',
                'email' => 'admin@example.com',
                'no_hp' => '081234567890',
                'username' => 'admin',
                'password' => 'admin123',
                'role' => 'admin',
            ]
        );

        // Create regular user/librarian
        User::firstOrCreate(
            ['username' => 'librarian'],
            [
                'name' => 'Pustakawan',
                'member_id' => 'LIB001',
                'email' => 'librarian@example.com',
                'no_hp' => '081234567891',
                'username' => 'librarian',
                'password' => 'librarian123',
                'role' => 'user',
            ]
        );
    }
}
