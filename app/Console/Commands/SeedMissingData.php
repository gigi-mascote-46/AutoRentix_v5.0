<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;

// Esta classe define um comando personalizado do Artisan para fazer seed apenas dos dados em falta,
// sem afetar os dados já existentes na base de dados.
class SeedMissingData extends Command
{
    // Define o nome do comando que pode ser executado via terminal: `php artisan db:seed-missing`
    protected $signature = 'db:seed-missing';

    // Descrição do comando, aparece quando se faz `php artisan list` ou `php artisan help db:seed-missing`
    protected $description = 'Seed only missing data without affecting existing tables';

    // Método principal que é executado quando o comando é chamado
    public function handle()
    {
        $this->info('Seeding only missing data...'); // Mensagem inicial no terminal

        // Lista de seeders que devem ser executados — cada um é responsável por popular uma tabela específica
        $seeders = [
            'TipoBemSeeder',
            'MarcaSeeder',
            'BemLocavelSeeder',
            'LocalizacaoSeeder',
            'CaracteristicaSeeder',
            'BemCaracteristicaSeeder',
            // Posso adicionar mais seeders aqui, conforme necessário
        ];

        // Loop por cada seeder e execução individual
        foreach ($seeders as $seeder) {
            $this->info("Seeding: $seeder"); // Indica qual seeder está a ser executado no momento

            // Chama o seeder específico usando o Artisan internamente
            Artisan::call('db:seed', ['--class' => "Database\\Seeders\\$seeder"]);

            // Mostra a saída da execução de cada seeder
            $this->info(Artisan::output());
        }

        // Mensagem final quando tudo terminar
        $this->info('Seeding completed.');
    }
}
