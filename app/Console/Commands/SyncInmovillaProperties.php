<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\Address;
use App\Models\PropertyImage;
use App\Services\InmovillaApiService;
use App\Services\InmovillaPropertyMapper;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;
use Carbon\Carbon;

class SyncInmovillaProperties extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'inmovilla:sync 
                            {--type=full : Tipo de sincronización (full|delta|featured)}
                            {--batch-size=50 : Número de propiedades por lote}
                            {--limit=0 : Limitar el número total de propiedades a procesar (0 = sin límite)}
                            {--force : Forzar sincronización ignorando caché}
                            {--dry-run : Simular sin guardar cambios}';

    /**
     * The console command description.
     */
    protected $description = 'Sincroniza propiedades desde la API de Inmovilla';

    private $apiService;
    private $mapper;
    private $stats;

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $startTime = microtime(true);
        
        try {
            $this->initializeServices();
            $this->initializeStats();
            
            $syncType = $this->option('type');
            $this->info("🚀 Iniciando sincronización Inmovilla - Tipo: {$syncType}");
            
            // Verificar si ya hay una sincronización en progreso
            if (!$this->option('force') && $this->isSyncInProgress()) {
                $this->error('❌ Sincronización ya en progreso. Use --force para omitir.');
                return Command::FAILURE;
            }
            
            // Marcar sincronización como en progreso
            $this->setSyncStatus('in_progress');
            
            switch ($syncType) {
                case 'full':
                    $result = $this->performFullSync();
                    break;
                case 'delta':
                    $result = $this->performDeltaSync();
                    break;
                case 'featured':
                    $result = $this->performFeaturedSync();
                    break;
                default:
                    $this->error("❌ Tipo de sincronización no válido: {$syncType}");
                    return Command::FAILURE;
            }
            
            $this->setSyncStatus($result ? 'completed' : 'failed');
            $this->displayResults($startTime);
            
            return $result ? Command::SUCCESS : Command::FAILURE;
            
        } catch (Exception $e) {
            $this->setSyncStatus('failed');
            $this->error("❌ Error durante la sincronización: {$e->getMessage()}");
            Log::error('Error en sincronización Inmovilla', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    /**
     * Inicializa los servicios necesarios
     */
    private function initializeServices()
    {
        $this->apiService = new InmovillaApiService();
        $this->mapper = new InmovillaPropertyMapper();
        
        $this->info('✅ Servicios inicializados');
    }

    /**
     * Inicializa las estadísticas de sincronización
     */
    private function initializeStats()
    {
        $this->stats = [
            'total_processed' => 0,
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => 0,
            'api_calls' => 0,
        ];
    }

    /**
     * Realiza sincronización completa
     */
    private function performFullSync(): bool
    {
        $this->info('📊 Iniciando sincronización completa...');
        
        try {
            // Primero sincronizar tipos de propiedad
            $this->syncPropertyTypes();
            
            // Obtener códigos de propiedades disponibles
            $availableCodes = $this->apiService->getAvailablePropertyCodes();
            $this->stats['api_calls']++;
            
            // Aplicar el límite si se ha especificado
            $limit = (int) $this->option('limit');
            if ($limit > 0) {
                $this->warn("⚠️  Aplicando límite de {$limit} propiedades.");
                $availableCodes = array_slice($availableCodes, 0, $limit);
            }

            $this->info("📋 Propiedades disponibles en Inmovilla: " . count($availableCodes));
            
            // Procesar en lotes
            $batchSize = $this->option('batch-size');
            $totalPages = ceil(count($availableCodes) / $batchSize);
            
            $this->withProgressBar(range(1, $totalPages), function ($page) use ($batchSize) {
                $this->processBatch($page, $batchSize);
            });
            
            $this->newLine(2);
            
            // Sincronizar propiedades destacadas
            $this->syncFeaturedProperties();
            
            return true;
            
        } catch (Exception $e) {
            $this->error("❌ Error en sincronización completa: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Realiza sincronización delta (solo propiedades actualizadas)
     */
    private function performDeltaSync(): bool
    {
        $this->info('⚡ Iniciando sincronización delta...');
        
        try {
            // Obtener fecha de última sincronización
            $lastSync = Cache::get('inmovilla_last_sync', Carbon::now()->subHours(24));
            $since = $lastSync->format('Y-m-d H:i:s');
            
            $this->info("📅 Sincronizando cambios desde: {$since}");
            
            // Obtener propiedades actualizadas
            $response = $this->apiService->getUpdatedPropertiesSince($since);
            $this->stats['api_calls']++;
            
            $properties = $response['properties'] ?? [];
            $this->info("🔄 Propiedades actualizadas: " . count($properties));
            
            if (empty($properties)) {
                $this->info('✅ No hay propiedades para actualizar');
                return true;
            }
            
            // Procesar propiedades actualizadas
            $this->withProgressBar($properties, function ($property) {
                $this->processProperty($property);
            });
            
            $this->newLine(2);
            
            // Actualizar timestamp de última sincronización
            Cache::put('inmovilla_last_sync', Carbon::now(), 86400);
            
            return true;
            
        } catch (Exception $e) {
            $this->error("❌ Error en sincronización delta: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Sincroniza solo propiedades destacadas
     */
    private function performFeaturedSync(): bool
    {
        $this->info('⭐ Iniciando sincronización de destacadas...');
        
        try {
            $featuredProperties = $this->apiService->getFeaturedProperties();
            $this->stats['api_calls']++;
            
            $this->info("⭐ Propiedades destacadas: " . count($featuredProperties));
            
            // Primero, quitar el destacado de todas las propiedades
            if (!$this->option('dry-run')) {
                Property::where('is_featured', true)->update(['is_featured' => false]);
            }
            
            // Procesar propiedades destacadas
            $this->withProgressBar($featuredProperties, function ($property) {
                $this->processProperty($property, true);
            });
            
            $this->newLine(2);
            
            return true;
            
        } catch (Exception $e) {
            $this->error("❌ Error sincronizando destacadas: {$e->getMessage()}");
            return false;
        }
    }

    /**
     * Sincroniza tipos de propiedad
     */
    private function syncPropertyTypes()
    {
        $this->info('🏠 Sincronizando tipos de propiedad...');
        
        try {
            $types = $this->apiService->getPropertyTypes();
            $this->stats['api_calls']++;
            
            $this->info("📋 Tipos de propiedad: " . count($types));
            
            // Los tipos se crean automáticamente en el mapper
            // Aquí solo registramos el evento
            Log::info('Tipos de propiedad sincronizados', ['count' => count($types)]);
            
        } catch (Exception $e) {
            $this->warn("⚠️ Error sincronizando tipos: {$e->getMessage()}");
        }
    }

    /**
     * Procesa un lote de propiedades
     */
    private function processBatch(int $page, int $batchSize)
    {
        try {
            $response = $this->apiService->getProperties($page, $batchSize);
            $this->stats['api_calls']++;
            
            $properties = $response['properties'] ?? [];
            
            foreach ($properties as $property) {
                $this->processProperty($property);
            }
            
        } catch (Exception $e) {
            $this->error("❌ Error procesando lote {$page}: {$e->getMessage()}");
            $this->stats['errors']++;
        }
    }

    /**
     * Procesa una propiedad individual
     */
    private function processProperty(array $inmovillaProperty, bool $isFeatured = false)
    {
        $this->stats['total_processed']++;
        
        try {
            // Mapear datos de Inmovilla a Laravel
            $mappedData = $this->mapper->mapProperty($inmovillaProperty);
            $addressData = $this->mapper->mapAddress($inmovillaProperty);
            
            if ($isFeatured) {
                $mappedData['is_featured'] = true;
            }
            
            // Verificar si es dry-run
            if ($this->option('dry-run')) {
                $this->line("  [DRY-RUN] Procesaría: {$mappedData['reference']}");
                return;
            }
            
            // Buscar propiedad existente
            $property = Property::where('reference', $mappedData['reference'])
                              ->orWhere('inmovilla_code', $mappedData['inmovilla_code'])
                              ->first();
            
            DB::beginTransaction();
            
            if ($property) {
                // Actualizar propiedad existente
                $property->update($mappedData);
                
                // Actualizar dirección
                if ($property->address) {
                    $property->address->update($addressData);
                } else {
                    $addressData['property_id'] = $property->id;
                    Address::create($addressData);
                }
                
                $this->stats['updated']++;
                Log::info('Propiedad actualizada', ['reference' => $property->reference]);
                
            } else {
                // Crear nueva propiedad
                $property = Property::create($mappedData);
                
                // Crear dirección
                $addressData['property_id'] = $property->id;
                Address::create($addressData);
                
                $this->stats['created']++;
                Log::info('Propiedad creada', ['reference' => $property->reference]);
            }
            
            DB::commit();
            
        } catch (Exception $e) {
            DB::rollBack();
            $this->stats['errors']++;
            
            Log::error('Error procesando propiedad', [
                'cod_ofer' => $inmovillaProperty['cod_ofer'] ?? 'N/A',
                'error' => $e->getMessage()
            ]);
        }
    }

    /**
     * Sincroniza propiedades destacadas
     */
    private function syncFeaturedProperties()
    {
        $this->info('⭐ Sincronizando propiedades destacadas...');
        
        try {
            // Quitar destacado de todas las propiedades actuales
            if (!$this->option('dry-run')) {
                Property::where('is_featured', true)->update(['is_featured' => false]);
            }
            
            // Obtener y procesar destacadas
            $featuredProperties = $this->apiService->getFeaturedProperties();
            $this->stats['api_calls']++;
            
            foreach ($featuredProperties as $featured) {
                // Buscar la propiedad y marcarla como destacada
                $property = Property::where('inmovilla_code', $featured['cod_ofer'])->first();
                
                if ($property && !$this->option('dry-run')) {
                    $property->update(['is_featured' => true]);
                }
            }
            
            $this->info("⭐ Propiedades destacadas procesadas: " . count($featuredProperties));
            
        } catch (Exception $e) {
            $this->warn("⚠️ Error sincronizando destacadas: {$e->getMessage()}");
        }
    }

    /**
     * Verifica si hay una sincronización en progreso
     */
    private function isSyncInProgress(): bool
    {
        return Cache::get('inmovilla_sync_status') === 'in_progress';
    }

    /**
     * Establece el estado de sincronización
     */
    private function setSyncStatus(string $status)
    {
        Cache::put('inmovilla_sync_status', $status, 3600);
        Cache::put('inmovilla_sync_last_run', Carbon::now(), 86400);
    }

    /**
     * Muestra los resultados de la sincronización
     */
    private function displayResults(float $startTime)
    {
        $duration = round(microtime(true) - $startTime, 2);
        
        $this->newLine();
        $this->info('📊 RESULTADOS DE SINCRONIZACIÓN');
        $this->info('================================');
        $this->info("⏱️  Tiempo total: {$duration} segundos");
        $this->info("📊 Total procesadas: {$this->stats['total_processed']}");
        $this->info("✅ Creadas: {$this->stats['created']}");
        $this->info("🔄 Actualizadas: {$this->stats['updated']}");
        $this->info("⏭️  Omitidas: {$this->stats['skipped']}");
        $this->info("❌ Errores: {$this->stats['errors']}");
        $this->info("🌐 Llamadas API: {$this->stats['api_calls']}");
        
        // Guardar estadísticas en cache
        Cache::put('inmovilla_last_sync_stats', $this->stats, 86400);
        
        Log::info('Sincronización Inmovilla completada', [
            'duration' => $duration,
            'stats' => $this->stats
        ]);
    }
}