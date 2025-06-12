<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class EchoServerCheck extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'echo:check';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check if Redis and Laravel Echo Server are installed and running';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Checking Redis status...');
        $redisStatus = $this->checkRedis();
        if ($redisStatus) {
            $this->info('Redis is installed and running.');
        } else {
            $this->error('Redis is not running or not installed.');
        }

        $this->info('Checking Laravel Echo Server status...');
        $echoStatus = $this->checkEchoServer();
        if ($echoStatus) {
            $this->info('Laravel Echo Server is installed and running.');
        } else {
            $this->error('Laravel Echo Server is not running or not installed.');
        }

        return 0;
    }

    protected function checkRedis()
    {
        // Try to ping Redis server
        try {
            $process = new Process(['redis-cli', 'ping']);
            $process->run();

            if ($process->isSuccessful() && trim($process->getOutput()) === 'PONG') {
                return true;
            }
        } catch (\Exception $e) {
            // Ignore exceptions
        }

        return false;
    }

    protected function checkEchoServer()
    {
        // Check if laravel-echo-server process is running on port 6001
        try {
            $process = new Process(['netstat', '-an']);
            $process->run();

            if ($process->isSuccessful()) {
                $output = $process->getOutput();
                // Check if port 6001 is listening
                if (stripos($output, ':6001') !== false) {
                    return true;
                }
            }
        } catch (\Exception $e) {
            // Ignore exceptions
        }

        return false;
    }
}
