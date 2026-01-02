<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Exception;

class MailCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * Você pode chamar de: php artisan mail:check
     *
     * @var string
     */
    protected $signature = 'mail:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Envia um e-mail de teste via Mailtrap para verificar a configuração.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Iniciando verificação de e-mail...');
        try {
            Mail::raw('Este é um e-mail de teste enviado pelo comando mail:check', function ($message) {
                // Defina um destinatário de teste — pode ser o seu próprio e-mail
                $message->to('teste@seuapp.test')
                        ->subject('Teste de Mailtrap via Artisan');
            });

            $this->info('✔ E-mail de teste enviado com sucesso para Mailtrap!');
            return 0; // sucesso
        } catch (Exception $e) {
            $this->error('✖ Falha ao enviar e-mail: ' . $e->getMessage());
            return 1; // erro
        }
    }
}
