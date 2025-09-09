<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\Address;
use App\Models\PropertyDescription;
use App\Models\PropertyVideo;
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
    protected $signature = 'inmovilla:sync 
                            {--type=full : Tipo de sincronización (full|delta|featured)}
                            {--batch-size=50 : Número de propiedades por lote}
                            {--limit=0 : Limitar el número total de propiedades a procesar (0 = sin límite)}
                            {--force : Forzar sincronización ignorando caché}
                            {--dry-run : Simular sin guardar cambios}';

    protected $description = 'Sincroniza propiedades desde la API de Inmovilla usando mapeo híbrido';

    private $apiService;
    private $mapper;
    private $stats;

    public function handle()
    {
        $startTime = microtime(true);
        
        try {
            $this->initializeServices();
            $this->initializeStats();
            
            $syncType = $this->option('type');
            $this->info("🏠 Iniciando sincronización Inmovilla - Tipo: {$syncType}");
            
            if (!$this->option('force') && $this->isSyncInProgress()) {
                $this->error('⚠️  Sincronización ya en progreso. Use --force para omitir.');
                return Command::FAILURE;
            }
            
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
            $this->error("💥 Error durante la sincronización: {$e->getMessage()}");
            Log::error('Error en sincronización Inmovilla', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return Command::FAILURE;
        }
    }

    private function initializeServices()
    {
        $this->apiService = new InmovillaApiService();
        $this->mapper = new InmovillaPropertyMapper();
        $this->info('✅ Servicios inicializados (API + Mapper)');
    }

    private function initializeStats()
    {
        $this->stats = [
            'total_processed' => 0,
            'created' => 0,
            'updated' => 0,
            'skipped' => 0,
            'errors' => 0,
            'api_calls' => 0,
            'addresses_created' => 0,
            'addresses_updated' => 0,
            'descriptions_created' => 0,
            'videos_created' => 0,
        ];
    }

    private function performFullSync(): bool
    {
        $this->info('🔄 Iniciando sincronización completa...');
        
        try {
            // Sincronizar tipos de propiedad primero
            $this->syncPropertyTypes();
            
            // Obtener códigos disponibles
            $availableCodes = $this->apiService->getAvailablePropertyCodes();
            $this->stats['api_calls']++;
            
            $limit = (int) $this->option('limit');
            if ($limit > 0) {
                $this->warn("⚠️  Aplicando límite de {$limit} propiedades.");
                $availableCodes = array_slice($availableCodes, 0, $limit);
            }

            $this->info("📊 Propiedades disponibles en Inmovilla: " . count($availableCodes));
            
            $batchSize = $this->option('batch-size');
            $totalPages = ceil(count($availableCodes) / $batchSize);
            
            $this->withProgressBar(range(1, $totalPages), function ($page) use ($batchSize) {
                $this->processBatch($page, $batchSize);
            });
            
            $this->newLine(2);
            $this->syncFeaturedProperties();
            
            return true;
            
        } catch (Exception $e) {
            $this->error("💥 Error en sincronización completa: {$e->getMessage()}");
            return false;
        }
    }

    private function performDeltaSync(): bool
    {
        $this->info('🔄 Iniciando sincronización delta...');
        
        try {
            $lastSync = Cache::get('inmovilla_last_sync', Carbon::now()->subHours(24));
            $since = $lastSync->format('Y-m-d H:i:s');
            
            $this->info("📅 Sincronizando cambios desde: {$since}");
            
            $response = $this->apiService->getUpdatedPropertiesSince($since);
            $this->stats['api_calls']++;
            
            $properties = $response['properties'] ?? [];
            $this->info("📈 Propiedades actualizadas: " . count($properties));
            
            if (empty($properties)) {
                $this->info('✅ No hay propiedades para actualizar');
                return true;
            }
            
            $this->withProgressBar($properties, function ($property) {
                $this->processProperty($property);
            });
            
            $this->newLine(2);
            Cache::put('inmovilla_last_sync', Carbon::now(), 86400);
            
            return true;
            
        } catch (Exception $e) {
            $this->error("💥 Error en sincronización delta: {$e->getMessage()}");
            return false;
        }
    }

    private function performFeaturedSync(): bool
    {
        $this->info('⭐ Iniciando sincronización de destacadas...');
        
        try {
            $featuredProperties = $this->apiService->getFeaturedProperties();
            $this->stats['api_calls']++;
            
            $this->info("⭐ Propiedades destacadas: " . count($featuredProperties));
            
            // Resetear destacadas existentes
            if (!$this->option('dry-run')) {
                Property::where('is_featured', true)->update(['is_featured' => false]);
                Property::where('destacado', '>', 0)->update(['destacado' => 0]);
            }
            
            $this->withProgressBar($featuredProperties, function ($property) {
                $this->processProperty($property, true);
            });
            
            $this->newLine(2);
            
            return true;
            
        } catch (Exception $e) {
            $this->error("💥 Error sincronizando destacadas: {$e->getMessage()}");
            return false;
        }
    }

    private function syncPropertyTypes()
    {
        $this->info('🏗️  Sincronizando tipos de propiedad...');
        
        try {
            $types = $this->apiService->getPropertyTypes();
            $this->stats['api_calls']++;
            
            $this->info("📋 Tipos de propiedad: " . count($types));
            Log::info('Tipos de propiedad sincronizados', ['count' => count($types)]);
            
        } catch (Exception $e) {
            $this->warn("⚠️  Error sincronizando tipos: {$e->getMessage()}");
        }
    }

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
            $this->error("💥 Error procesando lote {$page}: {$e->getMessage()}");
            $this->stats['errors']++;
        }
    }

    private function processProperty(array $inmovillaProperty, bool $isFeatured = false)
    {
        $this->stats['total_processed']++;
        
        try {
            $codOfer = $inmovillaProperty['cod_ofer'] ?? null;
            
            if (!$codOfer) {
                $this->stats['skipped']++;
                return;
            }
            
            // Usar el mapper para convertir datos de Inmovilla
            $mappedData = $this->mapper->mapProperty($inmovillaProperty);
            $addressData = $this->mapper->mapAddress($inmovillaProperty);
            
            // Sobrescribir featured si viene del sync de destacadas
            if ($isFeatured) {
                $mappedData['is_featured'] = true;
                $mappedData['destacado'] = 1;
            }
            
            if ($this->option('dry-run')) {
                $this->line("  [DRY-RUN] Procesaría: {$mappedData['reference']} (COD: {$codOfer})");
                return;
            }
            
            // Buscar propiedad existente por cod_ofer
            $property = Property::where('cod_ofer', $codOfer)->first();
            
            DB::beginTransaction();
            
            if ($property) {
                // Actualizar propiedad existente
                $property->update($mappedData);
                $this->updateRelatedData($property, $inmovillaProperty, $addressData);
                $this->stats['updated']++;
                
                Log::info('Propiedad actualizada', [
                    'cod_ofer' => $codOfer,
                    'reference' => $property->reference
                ]);
                
            } else {
                // Crear nueva propiedad
                $property = Property::create($mappedData);
                $this->createRelatedData($property, $inmovillaProperty, $addressData);
                $this->stats['created']++;
                
                Log::info('Propiedad creada', [
                    'cod_ofer' => $codOfer,
                    'reference' => $property->reference
                ]);
            }
            
            DB::commit();
            
        } catch (Exception $e) {
            DB::rollBack();
            $this->stats['errors']++;
            
            Log::error('Error procesando propiedad', [
                'cod_ofer' => $inmovillaProperty['cod_ofer'] ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
        }
    }

    private function updateRelatedData(Property $property, array $inmovillaData, array $addressData)
    {
        // Actualizar dirección
        if ($property->address) {
            $property->address->update($addressData);
            $this->stats['addresses_updated']++;
        } else {
            $addressData['property_id'] = $property->id;
            Address::create($addressData);
            $this->stats['addresses_created']++;
        }
        
        // Actualizar/crear descripciones multiidioma
        $this->syncPropertyDescriptions($property, $inmovillaData);
        
        // Actualizar/crear videos si existen
        $this->syncPropertyVideos($property, $inmovillaData);
    }

    private function createRelatedData(Property $property, array $inmovillaData, array $addressData)
    {
        // Crear dirección
        $addressData['property_id'] = $property->id;
        Address::create($addressData);
        $this->stats['addresses_created']++;
        
        // Crear descripciones multiidioma
        $this->syncPropertyDescriptions($property, $inmovillaData);
        
        // Crear videos si existen
        $this->syncPropertyVideos($property, $inmovillaData);
    }

    private function syncPropertyDescriptions(Property $property, array $inmovillaData)
    {
        // Descripción principal en español
        if (!empty($inmovillaData['titulo']) || !empty($inmovillaData['descrip'])) {
            PropertyDescription::updateOrCreate(
                [
                    'property_id' => $property->id,
                    'inmovilla_language_id' => 1, // Español
                ],
                [
                    'locale' => 'es',
                    'title' => $inmovillaData['titulo'] ?? null,
                    'description' => $inmovillaData['descrip'] ?? null,
                ]
            );
            $this->stats['descriptions_created']++;
        }
        
        // TODO: Aquí se pueden agregar otros idiomas si la API los proporciona
        // Ejemplo: si vienen campos como 'titulo_en', 'descrip_en', etc.
    }

    private function syncPropertyVideos(Property $property, array $inmovillaData)
    {
        // Video principal si existe
        if (!empty($inmovillaData['video_url']) || !empty($inmovillaData['youtube_code'])) {
            PropertyVideo::updateOrCreate(
                [
                    'property_id' => $property->id,
                    'is_inmovilla' => true,
                    'order' => 0,
                ],
                [
                    'video_url' => $inmovillaData['video_url'] ?? null,
                    'youtube_code' => $inmovillaData['youtube_code'] ?? null,
                    'title' => 'Video de la propiedad',
                ]
            );
            $this->stats['videos_created']++;
        }
    }

    private function syncFeaturedProperties()
    {
        $this->info('⭐ Sincronizando propiedades destacadas...');
        
        try {
            // Resetear destacadas actuales
            if (!$this->option('dry-run')) {
                Property::where('is_featured', true)->update(['is_featured' => false]);
            }
            
            $featuredProperties = $this->apiService->getFeaturedProperties();
            $this->stats['api_calls']++;
            
            foreach ($featuredProperties as $featured) {
                $property = Property::where('cod_ofer', $featured['cod_ofer'])->first();
                
                if ($property && !$this->option('dry-run')) {
                    $property->update([
                        'is_featured' => true,
                        'destacado' => $featured['destacado'] ?? 1
                    ]);
                }
            }
            
            $this->info("⭐ Propiedades destacadas procesadas: " . count($featuredProperties));
            
        } catch (Exception $e) {
            $this->warn("⚠️  Error sincronizando destacadas: {$e->getMessage()}");
        }
    }

    private function isSyncInProgress(): bool
    {
        return Cache::get('inmovilla_sync_status') === 'in_progress';
    }

    private function setSyncStatus(string $status)
    {
        Cache::put('inmovilla_sync_status', $status, 3600);
        Cache::put('inmovilla_sync_last_run', Carbon::now(), 86400);
    }

    private function displayResults(float $startTime)
    {
        $duration = round(microtime(true) - $startTime, 2);
        
        $this->newLine();
        $this->info('🎉 RESULTADOS DE SINCRONIZACIÓN');
        $this->info('====================================');
        $this->info("⏱️  Tiempo total: {$duration} segundos");
        $this->info("📊 Total procesadas: {$this->stats['total_processed']}");
        $this->info("🆕 Creadas: {$this->stats['created']}");
        $this->info("🔄 Actualizadas: {$this->stats['updated']}");
        $this->info("⏭️  Omitidas: {$this->stats['skipped']}");
        $this->info("❌ Errores: {$this->stats['errors']}");
        $this->info("🔗 Llamadas API: {$this->stats['api_calls']}");
        $this->info("🏠 Direcciones creadas: {$this->stats['addresses_created']}");
        $this->info("🏠 Direcciones actualizadas: {$this->stats['addresses_updated']}");
        $this->info("📝 Descripciones creadas: {$this->stats['descriptions_created']}");
        $this->info("🎥 Videos creados: {$this->stats['videos_created']}");
        
        // Mostrar resumen de eficiencia
        if ($this->stats['total_processed'] > 0) {
            $successRate = round((($this->stats['created'] + $this->stats['updated']) / $this->stats['total_processed']) * 100, 2);
            $this->info("✅ Tasa de éxito: {$successRate}%");
        }
        
        Cache::put('inmovilla_last_sync_stats', $this->stats, 86400);
        
        Log::info('Sincronización Inmovilla completada', [
            'duration' => $duration,
            'stats' => $this->stats
        ]);
    }
}