<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class MaintenanceCheckCommand extends Command
{
    protected $signature = 'maintenance:check';
    protected $description = 'Verificación rápida semanal del sistema Conforthouse';

    private array $issues = [];

    public function handle()
    {
        $this->info('🔍 Verificación rápida - ' . now()->format('d/m/Y H:i'));
        $this->info('');

        $this->checkDatabase();
        $this->checkProperties();
        $this->checkSync();
        $this->checkLogs();
        $this->checkWebsite();

        $this->info('');
        
        if (empty($this->issues)) {
            $this->info('✅ Todo OK - Sistema funcionando correctamente');
            return Command::SUCCESS;
        }

        $this->warn('⚠️  Problemas detectados:');
        foreach ($this->issues as $issue) {
            $this->warn("   - {$issue}");
        }

        return Command::FAILURE;
    }

    private function checkDatabase()
    {
        $this->output->write('   Base de datos... ');
        try {
            DB::connection()->getPdo();
            $this->info('✅');
        } catch (\Exception $e) {
            $this->error('❌');
            $this->issues[] = 'Base de datos no conecta';
        }
    }

    private function checkProperties()
    {
        $this->output->write('   Propiedades... ');
        try {
            $count = Property::count();
            if ($count > 0) {
                $this->info("✅ ({$count})");
            } else {
                $this->warn('⚠️  (0 propiedades)');
                $this->issues[] = 'No hay propiedades en la base de datos';
            }
        } catch (\Exception $e) {
            $this->error('❌');
            $this->issues[] = 'Error consultando propiedades';
        }
    }

    private function checkSync()
    {
        $this->output->write('   Sync Inmovilla... ');
        $lastSync = Cache::get('inmovilla_sync_last_run');
        
        if ($lastSync && $lastSync->diffInDays(now()) <= 2) {
            $this->info('✅');
        } else {
            $this->warn('⚠️');
            $this->issues[] = 'Sincronización Inmovilla sin ejecutar en +2 días';
        }
    }

    private function checkLogs()
    {
        $this->output->write('   Logs... ');
        $logPath = storage_path('logs/laravel.log');
        
        if (file_exists($logPath)) {
            $sizeMB = filesize($logPath) / 1024 / 1024;
            if ($sizeMB < 50) {
                $this->info('✅ (' . round($sizeMB, 1) . ' MB)');
            } else {
                $this->warn('⚠️ (' . round($sizeMB, 1) . ' MB)');
                $this->issues[] = 'Logs demasiado grandes (>50MB)';
            }
        } else {
            $this->info('✅');
        }
    }

    private function checkWebsite()
    {
        $this->output->write('   Website... ');
        try {
            $url = config('app.url') . '/health';
            $response = Http::timeout(10)->get($url);
            
            if ($response->successful()) {
                $data = $response->json();
                if (($data['status'] ?? '') === 'ok') {
                    $this->info('✅');
                } else {
                    $this->warn('⚠️');
                    $this->issues[] = 'Health check reporta estado degradado';
                }
            } else {
                $this->error('❌');
                $this->issues[] = 'Website no responde correctamente';
            }
        } catch (\Exception $e) {
            $this->warn('⚠️ (no verificable)');
        }
    }
}