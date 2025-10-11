<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ActualizarPreciosKardexCommand::class,
        Commands\VerificarCertificadosVencimiento::class,
    ];

    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Verificar certificados médicos próximos a vencer todos los días a las 8:00 AM
        $schedule->command('certificados:verificar-vencimiento')
            ->dailyAt('08:00')
            ->timezone('America/Lima');
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
