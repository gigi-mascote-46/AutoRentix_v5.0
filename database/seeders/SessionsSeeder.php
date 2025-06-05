<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SessionsSeeder extends Seeder
{
    public function run()
    {
        // Example seed data for sessions table
        DB::table('sessions')->insert([
            [
                'id' => (string) Str::uuid(),
                'user_id' => 1,
                'ip_address' => '127.0.0.1',
                'user_agent' => 'Mozilla/5.0',
                'payload' => json_encode(['some' => 'data']),
                'last_activity' => time(),
            ],
            [
                'id' => (string) Str::uuid(),
                'user_id' => 2,
                'ip_address' => '192.168.1.1',
                'user_agent' => 'Mozilla/5.0',
                'payload' => json_encode(['other' => 'data']),
                'last_activity' => time(),
            ],
        ]);
    }
}
