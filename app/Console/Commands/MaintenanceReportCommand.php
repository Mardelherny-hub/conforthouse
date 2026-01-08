<?php

namespace App\Console\Commands;

use App\Models\Property;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class MaintenanceReportCommand extends Command
{
    protected $signature = 'maintenance:report';
    protected $description = 'Genera informe mensual de mantenimiento para Conforthouse';

    public function handle()
    {
        $this->info('');
        $this->info('╔══════════════════════════════════════════════════════════════╗');
        $this->info('║       INFORME DE MANTENIMIENTO - CONFORTHOUSE                ║');
        $this->info('║       Fecha: ' . now()->format('d/m/Y H:i') . '                            ║');
        $this->info('╚══════════════════════════════════════════════════════════════╝');
        $this->info('');

        // 1. Estado de la base de datos
        $this->reportDatabase();

        // 2. Estado de propiedades
        $this->reportProperties();

        // 3. Sincronización Inmovilla
        $this->reportSync();

        // 4. Estado de logs
        $this->reportLogs();

        // 5. Estadísticas de spam
        $this->reportSpam();

        // 6. Resumen final
        $this->reportSummary();

        return Command::SUCCESS;
    }

    private function reportDatabase()
    {
        $this->info('📊 BASE DE DATOS');
        $this->info('────────────────────────────────────');
        
        try {
            DB::connection()->getPdo();
            $this->info('   Estado: ✅ Conectada');
            
            $dbName = DB::connection()->getDatabaseName();
            $this->info("   Nombre: {$dbName}");
        } catch (\Exception $e) {
            $this->error('   Estado: ❌ Error de conexión');
        }
        
        $this->info('');
    }

    private function reportProperties()
    {
        $this->info('🏠 PROPIEDADES');
        $this->info('────────────────────────────────────');
        
        $total = Property::count();
        $deleted = Property::onlyTrashed()->count();
        $featured = Property::where('is_featured', true)->count();
        
        $this->info("   Total activas:    {$total}");
        $this->info("   Eliminadas:       {$deleted}");
        $this->info("   Destacadas:       {$featured}");
        
        // Por tipo de operación
        $byOperation = Property::select('operation_id', DB::raw('count(*) as total'))
            ->groupBy('operation_id')
            ->pluck('total', 'operation_id')
            ->toArray();
        
        if (!empty($byOperation)) {
            $this->info('   Por operación:');
            foreach ($byOperation as $opId => $count) {
                $this->info("      - Operación {$opId}: {$count}");
            }
        }
        
        $this->info('');
    }

    private function reportSync()
    {
        $this->info('🔄 SINCRONIZACIÓN INMOVILLA');
        $this->info('────────────────────────────────────');
        
        $lastSync = Cache::get('inmovilla_sync_last_run');
        $lastStats = Cache::get('inmovilla_last_sync_stats');
        
        if ($lastSync) {
            $this->info('   Última sync: ' . $lastSync->format('d/m/Y H:i'));
            $this->info('   Hace: ' . $lastSync->diffForHumans());
        } else {
            $this->info('   Última sync: Sin registro en caché');
        }
        
        if ($lastStats) {
            $this->info('   Última estadística:');
            $this->info("      - Procesadas: " . ($lastStats['total_processed'] ?? 'N/A'));
            $this->info("      - Creadas: " . ($lastStats['created'] ?? 'N/A'));
            $this->info("      - Actualizadas: " . ($lastStats['updated'] ?? 'N/A'));
            $this->info("      - Errores: " . ($lastStats['errors'] ?? 'N/A'));
        }
        
        $this->info('');
    }

    private function reportLogs()
    {
        $this->info('📝 LOGS DEL SISTEMA');
        $this->info('────────────────────────────────────');
        
        $logPath = storage_path('logs/laravel.log');
        
        if (file_exists($logPath)) {
            $sizeMB = round(filesize($logPath) / 1024 / 1024, 2);
            $this->info("   Tamaño: {$sizeMB} MB");
            $this->info('   Ubicación: storage/logs/laravel.log');
            
            if ($sizeMB > 50) {
                $this->warn('   ⚠️  Considerar limpiar logs (>50MB)');
            } else {
                $this->info('   Estado: ✅ OK');
            }
        } else {
            $this->info('   Archivo de log no encontrado');
        }
        
        $this->info('');
    }

    private function reportSpam()
    {
        $this->info('🛡️  PROTECCIÓN ANTI-SPAM');
        $this->info('────────────────────────────────────');
        
        $statsFile = storage_path('app/spam_stats.json');
        
        if (!file_exists($statsFile)) {
            $this->info('   Sin intentos de spam registrados');
            $this->info('');
            return;
        }
        
        $stats = json_decode(file_get_contents($statsFile), true) ?? [];
        $currentMonth = date('Y-m');
        
        if (isset($stats[$currentMonth])) {
            $monthly = $stats[$currentMonth];
            $this->info("   Mes actual ({$currentMonth}):");
            $this->info("      Total bloqueados: {$monthly['total']}");
            $this->info("      Por User-Agent:   " . ($monthly['by_type']['user_agent'] ?? 0));
            $this->info("      Por Honeypot:     " . ($monthly['by_type']['honeypot'] ?? 0));
            $this->info("      Por Tiempo:       " . ($monthly['by_type']['time_check'] ?? 0));
            $this->info("      IPs únicas:       " . count($monthly['ips'] ?? []));
        } else {
            $this->info('   Sin intentos este mes');
        }
        
        // Total histórico
        $totalHistorico = 0;
        foreach ($stats as $month => $data) {
            $totalHistorico += $data['total'] ?? 0;
        }
        $this->info("   Total histórico:     {$totalHistorico}");
        
        $this->info('');
    }

    private function reportSummary()
    {
        $this->info('════════════════════════════════════════════════════════════════');
        $this->info('📋 RESUMEN');
        $this->info('────────────────────────────────────');
        
        $issues = [];
        
        // Verificar conexión BD
        try {
            DB::connection()->getPdo();
        } catch (\Exception $e) {
            $issues[] = 'Base de datos no conecta';
        }
        
        // Verificar sync reciente
        $lastSync = Cache::get('inmovilla_sync_last_run');
        if (!$lastSync || $lastSync->diffInDays(now()) > 2) {
            $issues[] = 'Sincronización Inmovilla sin ejecutar en +2 días';
        }
        
        // Verificar logs
        $logPath = storage_path('logs/laravel.log');
        if (file_exists($logPath) && filesize($logPath) > 50 * 1024 * 1024) {
            $issues[] = 'Logs demasiado grandes (>50MB)';
        }
        
        if (empty($issues)) {
            $this->info('   ✅ Sistema funcionando correctamente');
        } else {
            $this->warn('   ⚠️  Problemas detectados:');
            foreach ($issues as $issue) {
                $this->warn("      - {$issue}");
            }
        }
        
        $this->info('');
        $this->info('════════════════════════════════════════════════════════════════');
    }
}