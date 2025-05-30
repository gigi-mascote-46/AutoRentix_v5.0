<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        User::updateOrCreate(
            ['email' => 'admin@autorentix.pt'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password123'), // Change to a secure password
                'is_admin' => true,
                'role' => 'admin',

            ]
        );
    }
}
