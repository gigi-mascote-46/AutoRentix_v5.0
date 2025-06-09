<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SessionsSeeder extends Seeder
{
    public function run()
    {
        // Inserção de dados de exemplo para a tabela 'sessions'
        DB::table('sessions')->insert([
            [
                // Gera um UUID único para o id da sessão
                'id' => (string) Str::uuid(),
                // ID do utilizador associado à sessão
                'user_id' => 1,
                // Endereço IP do utilizador na sessão
                'ip_address' => '127.0.0.1',
                // Informação do agente do utilizador (navegador, dispositivo)
                'user_agent' => 'Mozilla/5.0',
                // Dados adicionais da sessão codificados em JSON
                'payload' => json_encode(['some' => 'data']),
                // Timestamp da última atividade da sessão
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
