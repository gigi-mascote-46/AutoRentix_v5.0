<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        // Cria usuário admin fixo conforme SQL script
        DB::table('users')->updateOrInsert(
            ['email' => 'admin@autorentix.pt'],
            [
                'name' => 'Admin AutoRentix',
                'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
                'is_admin' => true,
                'role' => 'admin',
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // Opcional: criar 10 usuários fictícios
        User::factory()->count(10)->create();
    }
}
