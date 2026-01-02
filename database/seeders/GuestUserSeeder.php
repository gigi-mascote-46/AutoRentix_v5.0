<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class GuestUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['id' => 9999],
            [
                'name' => 'Guest User',
                'email' => 'guest@example.com',
                'password' => Hash::make('guestpassword'),
                'role' => 'guest',
            ]
        );
    }
}
