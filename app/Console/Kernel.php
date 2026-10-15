<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\Log;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Solo habilitar tras QA y configuración explícita del acceso de lectura.
        if (config('maintenance_evidence.schedule_enabled', false)) {
            $schedule->command('maintenance:evidence --closed-cycle --store')
                ->monthlyOn(16, '08:00')
                ->timezone('Europe/Madrid')
                ->withoutOverlapping();
        }

        // Actualización diaria de Inmovilla - 3:00 AM
        $schedule->command('inmovilla:update')
            ->dailyAt('03:00')
            ->timezone('America/Argentina/Buenos_Aires')
            ->onSuccess(function () {
                Log::info('✅ Actualización automática Inmovilla completada');
            })
            ->onFailure(function () {
                Log::error('❌ Error en actualización automática Inmovilla');
            });
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