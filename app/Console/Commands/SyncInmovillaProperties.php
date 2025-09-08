<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\Address;
use App\Services\InmovillaApiService;
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

    protected $description = 'Sincroniza propiedades desde la API de Inmovilla';

    private $apiService;
    private $stats;

    public function handle()
    {
        $startTime = microtime(true);
        
        try {
            $this->initializeServices();
            $this->initializeStats();
            
            $syncType = $this->option('type');
            $this->info("Iniciando sincronización Inmovilla - Tipo: {$syncType}");
            
            if (!$this->option('force') && $this->isSyncInProgress()) {
                $this->error('Sincronización ya en progreso. Use --force para omitir.');
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
                    $this->error("Tipo de sincronización no válido: {$syncType}");
                    return Command::FAILURE;
            }
            
            $this->setSyncStatus($result ? 'completed' : 'failed');
            $this->displayResults($startTime);
            
            return $result ? Command::SUCCESS : Command::FAILURE;
            
        } catch (Exception $e) {
            $this->setSyncStatus('failed');
            $this->error("Error durante la sincronización: {$e->getMessage()}");
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
        $this->info('Servicios inicializados');
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
        ];
    }

    private function performFullSync(): bool
    {
        $this->info('Iniciando sincronización completa...');
        
        try {
            $this->syncPropertyTypes();
            
            $availableCodes = $this->apiService->getAvailablePropertyCodes();
            $this->stats['api_calls']++;
            
            $limit = (int) $this->option('limit');
            if ($limit > 0) {
                $this->warn("Aplicando límite de {$limit} propiedades.");
                $availableCodes = array_slice($availableCodes, 0, $limit);
            }

            $this->info("Propiedades disponibles en Inmovilla: " . count($availableCodes));
            
            $batchSize = $this->option('batch-size');
            $totalPages = ceil(count($availableCodes) / $batchSize);
            
            $this->withProgressBar(range(1, $totalPages), function ($page) use ($batchSize) {
                $this->processBatch($page, $batchSize);
            });
            
            $this->newLine(2);
            $this->syncFeaturedProperties();
            
            return true;
            
        } catch (Exception $e) {
            $this->error("Error en sincronización completa: {$e->getMessage()}");
            return false;
        }
    }

    private function performDeltaSync(): bool
    {
        $this->info('Iniciando sincronización delta...');
        
        try {
            $lastSync = Cache::get('inmovilla_last_sync', Carbon::now()->subHours(24));
            $since = $lastSync->format('Y-m-d H:i:s');
            
            $this->info("Sincronizando cambios desde: {$since}");
            
            $response = $this->apiService->getUpdatedPropertiesSince($since);
            $this->stats['api_calls']++;
            
            $properties = $response['properties'] ?? [];
            $this->info("Propiedades actualizadas: " . count($properties));
            
            if (empty($properties)) {
                $this->info('No hay propiedades para actualizar');
                return true;
            }
            
            $this->withProgressBar($properties, function ($property) {
                $this->processProperty($property);
            });
            
            $this->newLine(2);
            Cache::put('inmovilla_last_sync', Carbon::now(), 86400);
            
            return true;
            
        } catch (Exception $e) {
            $this->error("Error en sincronización delta: {$e->getMessage()}");
            return false;
        }
    }

    private function performFeaturedSync(): bool
    {
        $this->info('Iniciando sincronización de destacadas...');
        
        try {
            $featuredProperties = $this->apiService->getFeaturedProperties();
            $this->stats['api_calls']++;
            
            $this->info("Propiedades destacadas: " . count($featuredProperties));
            
            if (!$this->option('dry-run')) {
                Property::where('is_featured', true)->update(['is_featured' => false]);
            }
            
            $this->withProgressBar($featuredProperties, function ($property) {
                $this->processProperty($property, true);
            });
            
            $this->newLine(2);
            
            return true;
            
        } catch (Exception $e) {
            $this->error("Error sincronizando destacadas: {$e->getMessage()}");
            return false;
        }
    }

    private function syncPropertyTypes()
    {
        $this->info('Sincronizando tipos de propiedad...');
        
        try {
            $types = $this->apiService->getPropertyTypes();
            $this->stats['api_calls']++;
            
            $this->info("Tipos de propiedad: " . count($types));
            Log::info('Tipos de propiedad sincronizados', ['count' => count($types)]);
            
        } catch (Exception $e) {
            $this->warn("Error sincronizando tipos: {$e->getMessage()}");
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
            $this->error("Error procesando lote {$page}: {$e->getMessage()}");
            $this->stats['errors']++;
        }
    }

    private function processProperty(array $inmovillaProperty, bool $isFeatured = false)
    {
        $this->stats['total_processed']++;
        
        try {
            // Preparar datos básicos necesarios para Laravel
            $propertyData = $this->preparePropertyData($inmovillaProperty, $isFeatured);
            $addressData = $this->prepareAddressData($inmovillaProperty);
            
            if ($this->option('dry-run')) {
                $this->line("  [DRY-RUN] Procesaría: {$propertyData['reference']}");
                return;
            }
            
            // Buscar propiedad existente por cod_ofer
            $property = Property::where('cod_ofer', $inmovillaProperty['cod_ofer'])
                              ->orWhere('reference', $propertyData['reference'])
                              ->first();
            
            DB::beginTransaction();
            
            if ($property) {
                $property->update($propertyData);
                
                if ($property->address) {
                    $property->address->update($addressData);
                } else {
                    $addressData['property_id'] = $property->id;
                    Address::create($addressData);
                }
                
                $this->stats['updated']++;
                Log::info('Propiedad actualizada', ['cod_ofer' => $property->cod_ofer]);
                
            } else {
                $property = Property::create($propertyData);
                
                $addressData['property_id'] = $property->id;
                Address::create($addressData);
                
                $this->stats['created']++;
                Log::info('Propiedad creada', ['cod_ofer' => $property->cod_ofer]);
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

    private function preparePropertyData(array $inmovillaData, bool $isFeatured = false): array
    {
        // Tomar todos los datos de Inmovilla tal como vienen
        $propertyData = $inmovillaData;
        
        // Solo agregar los campos obligatorios mínimos que Laravel requiere
        $propertyData['reference'] = $inmovillaData['ref'] ?? 'REF-' . ($inmovillaData['cod_ofer'] ?? rand(1000, 9999));
        $propertyData['title'] = $inmovillaData['titulo'] ?? $this->generateTitle($inmovillaData);
        $propertyData['meta_description'] = $this->generateMetaDescription($inmovillaData);
        $propertyData['price'] = $inmovillaData['precioinmo'] ?? $inmovillaData['precioalq'] ?? 100000;
        $propertyData['is_featured'] = $isFeatured;
        
        // IDs obligatorios - usar valores por defecto temporales
        $propertyData['operation_id'] = 1; // Por defecto, se puede mejorar después
        $propertyData['property_type_id'] = 1; // Por defecto, se puede mejorar después  
        $propertyData['status_id'] = 1; // Por defecto, se puede mejorar después
        
        // Limpiar campos que no existen en la migración
        unset($propertyData['nbtipo'], $propertyData['tipo']);
        
        return $propertyData;
    }

    private function prepareAddressData(array $inmovillaData): array
    {
        return [
            'street' => $inmovillaData['direccion'] ?? 'Sin dirección',
            'city' => $inmovillaData['ciudad'] ?? 'Sin ciudad',
            'district' => $inmovillaData['zona'] ?? null,
            'province' => $inmovillaData['provincia'] ?? null,
            'postal_code' => $inmovillaData['cp'] ?? null,
            'autonomous_community' => null,
        ];
    }

    private function generateTitle(array $inmovillaData): string
    {
        $tipo = $inmovillaData['nbtipo'] ?? 'Propiedad';
        $ciudad = $inmovillaData['ciudad'] ?? '';
        $zona = $inmovillaData['zona'] ?? '';
        
        $title = $tipo;
        if ($zona) {
            $title .= " en $zona";
        } elseif ($ciudad) {
            $title .= " en $ciudad";
        }
        
        return $title;
    }

    private function generateMetaDescription(array $inmovillaData): string
    {
        $tipo = $inmovillaData['nbtipo'] ?? 'Propiedad';
        $ciudad = $inmovillaData['ciudad'] ?? '';
        $habitaciones = $inmovillaData['total_hab'] ?? $inmovillaData['habitaciones'] ?? 0;
        $metros = $inmovillaData['m_cons'] ?? 0;
        $precio = $inmovillaData['precioinmo'] ?? $inmovillaData['precioalq'] ?? 0;
        
        $meta = $tipo;
        if ($habitaciones > 0) {
            $meta .= " de $habitaciones habitaciones";
        }
        if ($metros > 0) {
            $meta .= " y {$metros}m²";
        }
        if ($ciudad) {
            $meta .= " en $ciudad";
        }
        if ($precio > 0) {
            $meta .= ". Precio: €" . number_format($precio, 0, ',', '.');
        }
        
        return $meta;
    }

    private function syncFeaturedProperties()
    {
        $this->info('Sincronizando propiedades destacadas...');
        
        try {
            if (!$this->option('dry-run')) {
                Property::where('is_featured', true)->update(['is_featured' => false]);
            }
            
            $featuredProperties = $this->apiService->getFeaturedProperties();
            $this->stats['api_calls']++;
            
            foreach ($featuredProperties as $featured) {
                $property = Property::where('cod_ofer', $featured['cod_ofer'])->first();
                
                if ($property && !$this->option('dry-run')) {
                    $property->update(['is_featured' => true]);
                }
            }
            
            $this->info("Propiedades destacadas procesadas: " . count($featuredProperties));
            
        } catch (Exception $e) {
            $this->warn("Error sincronizando destacadas: {$e->getMessage()}");
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
        $this->info('RESULTADOS DE SINCRONIZACIÓN');
        $this->info('================================');
        $this->info("Tiempo total: {$duration} segundos");
        $this->info("Total procesadas: {$this->stats['total_processed']}");
        $this->info("Creadas: {$this->stats['created']}");
        $this->info("Actualizadas: {$this->stats['updated']}");
        $this->info("Omitidas: {$this->stats['skipped']}");
        $this->info("Errores: {$this->stats['errors']}");
        $this->info("Llamadas API: {$this->stats['api_calls']}");
        
        Cache::put('inmovilla_last_sync_stats', $this->stats, 86400);
        
        Log::info('Sincronización Inmovilla completada', [
            'duration' => $duration,
            'stats' => $this->stats
        ]);
    }
}