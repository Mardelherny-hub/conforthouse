<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\InmovillaApiService;
use App\Services\InmovillaPropertyMapper;
use App\Services\BatchTranslationService;
use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Exception;
use Carbon\Carbon;

class InmovillaSyncController extends Controller
{
    private $apiService;
    private $mapper;
    private $translationService;

    public function __construct()
    {
        $this->apiService = new InmovillaApiService();
        $this->mapper = new InmovillaPropertyMapper();
        $this->translationService = new BatchTranslationService();
    }

    /**
     * Mostrar panel de sincronización
     */
    public function index()
    {
        // Obtener estadísticas actuales
        $stats = $this->getStats();
        
        // Obtener último estado de sincronización
        $lastSync = Cache::get('inmovilla_web_sync_status');
        
        return view('admin.inmovilla.sync', compact('stats', 'lastSync'));
    }

    /**
     * Verificar servicios via AJAX
     */
    public function checkServices()
    {
        $results = [
            'inmovilla' => false,
            'translation' => false,
            'messages' => [],
            'environment' => 'production' // Asumir producción por defecto
        ];

        // Verificar Inmovilla
        try {
            $types = $this->apiService->getPropertyTypes();
            if (!empty($types)) {
                $results['inmovilla'] = true;
                $results['messages'][] = '✅ Inmovilla: ' . count($types) . ' tipos disponibles';
            }
        } catch (Exception $e) {
            $results['messages'][] = '❌ Inmovilla: ' . $e->getMessage();
        }

        // Verificar traductor (solo en desarrollo/local)
        try {
            if ($this->translationService->isTranslationServiceAvailable()) {
                $results['translation'] = true;
                $results['environment'] = 'local';
                $results['messages'][] = '✅ LibreTranslate: Disponible (entorno local)';
            } else {
                $results['messages'][] = '⚠️ LibreTranslate: No disponible (normal en servidor producción)';
            }
        } catch (Exception $e) {
            $results['messages'][] = '⚠️ LibreTranslate: No disponible en este servidor';
        }

        return response()->json($results);
    }

    /**
     * Ejecutar sincronización masiva
     */
    public function sync(Request $request)
    {
        $request->validate([
        'limit' => 'nullable|integer|min:1|max:1000',
        'batch_size' => 'nullable|integer|min:10|max:100',
        'skip_translation' => 'boolean'
        ]);

        // En servidor de producción, forzar omitir traducción
        $skipTranslation = $request->boolean('skip_translation');
        if (!$this->translationService->isTranslationServiceAvailable()) {
            $skipTranslation = true;
        }

        // Marcar sincronización en progreso
        Cache::put('inmovilla_web_sync_status', [
            'status' => 'running',
            'started_at' => Carbon::now(),
            'progress' => 0,
            'message' => 'Iniciando sincronización...',
            'translation_available' => $this->translationService->isTranslationServiceAvailable()
        ], 3600);

        try {
            $limit = $request->input('limit', 0);
            $batchSize = $request->input('batch_size', 50);
            $skipTranslation = $request->boolean('skip_translation');

            $results = $this->performSync($limit, $batchSize, $skipTranslation);

            // Marcar como completado
            Cache::put('inmovilla_web_sync_status', [
                'status' => 'completed',
                'completed_at' => Carbon::now(),
                'results' => $results
            ], 3600);

            return response()->json([
                'success' => true,
                'message' => 'Sincronización completada',
                'results' => $results
            ]);

        } catch (Exception $e) {
            // Marcar como fallido
            Cache::put('inmovilla_web_sync_status', [
                'status' => 'failed',
                'failed_at' => Carbon::now(),
                'error' => $e->getMessage()
            ], 3600);

            Log::error('Error en sincronización web', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener progreso de sincronización
     */
    public function progress()
    {
        $status = Cache::get('inmovilla_web_sync_status', [
            'status' => 'idle',
            'message' => 'Sin actividad'
        ]);

        return response()->json($status);
    }

    /**
     * Ejecutar solo traducción
     */
    public function translate()
    {
        try {
            Cache::put('inmovilla_web_sync_status', [
                'status' => 'running',
                'started_at' => Carbon::now(),
                'message' => 'Traduciendo propiedades...'
            ], 3600);

            $results = $this->translationService->translateAllProperties();

            Cache::put('inmovilla_web_sync_status', [
                'status' => 'completed',
                'completed_at' => Carbon::now(),
                'results' => $results
            ], 3600);

            return response()->json([
                'success' => true,
                'message' => 'Traducción completada',
                'results' => $results
            ]);

        } catch (Exception $e) {
            Cache::put('inmovilla_web_sync_status', [
                'status' => 'failed',
                'failed_at' => Carbon::now(),
                'error' => $e->getMessage()
            ], 3600);

            return response()->json([
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ], 500);
        }
    }

    private function performSync($limit, $batchSize, $skipTranslation)
    {
        $stats = [
            'total_available' => 0,
            'processed' => 0,
            'created' => 0,
            'updated' => 0,
            'errors' => 0,
            'translation_stats' => null
        ];

        // Obtener códigos disponibles
        $availableCodes = $this->apiService->getAvailablePropertyCodes();
        $stats['total_available'] = count($availableCodes);

        if ($limit > 0) {
            $availableCodes = array_slice($availableCodes, 0, $limit);
        }

        // Procesar en lotes
        $batches = array_chunk($availableCodes, $batchSize);
        $totalBatches = count($batches);

        foreach ($batches as $batchIndex => $batch) {
            // Actualizar progreso
            $progress = round((($batchIndex + 1) / $totalBatches) * 100);
            Cache::put('inmovilla_web_sync_status', [
                'status' => 'running',
                'started_at' => Cache::get('inmovilla_web_sync_status.started_at'),
                'progress' => $progress,
                'message' => "Procesando lote " . ($batchIndex + 1) . " de {$totalBatches}"
            ], 3600);

            $batchStats = $this->processBatch($batch);
            $stats['processed'] += $batchStats['processed'];
            $stats['created'] += $batchStats['created'];
            $stats['updated'] += $batchStats['updated'];
            $stats['errors'] += $batchStats['errors'];
        }

        // Ejecutar traducción si corresponde
        if (!$skipTranslation) {
            Cache::put('inmovilla_web_sync_status', [
                'status' => 'running',
                'started_at' => Cache::get('inmovilla_web_sync_status.started_at'),
                'progress' => 100,
                'message' => 'Ejecutando traducciones...'
            ], 3600);

            $stats['translation_stats'] = $this->translationService->translateAllProperties();
        }

        return $stats;
    }

    private function processBatch(array $codes)
    {
        $stats = ['processed' => 0, 'created' => 0, 'updated' => 0, 'errors' => 0];

        try {
            $response = $this->apiService->getProperties(1, count($codes), 
                'codinm IN (' . implode(',', $codes) . ')');
            
            $properties = array_slice($response, 1); // Remover metadata

            foreach ($properties as $propertyData) {
                try {
                    $stats['processed']++;
                    
                    $propertyMapped = $this->mapper->mapProperty($propertyData);
                    $addressMapped = $this->mapper->mapAddress($propertyData);

                    $property = Property::where('reference', $propertyMapped['reference'])->first();

                    if ($property) {
                        $property->update($propertyMapped);
                        if ($property->address) {
                            $property->address->update($addressMapped);
                        }
                        $stats['updated']++;
                    } else {
                        $property = Property::create($propertyMapped);
                        $addressMapped['property_id'] = $property->id;
                        $property->address()->create($addressMapped);
                        $stats['created']++;
                    }

                } catch (Exception $e) {
                    $stats['errors']++;
                    Log::error('Error procesando propiedad', [
                        'reference' => $propertyData['codinm'] ?? 'N/A',
                        'error' => $e->getMessage()
                    ]);
                }
            }

        } catch (Exception $e) {
            $stats['errors']++;
            Log::error('Error procesando lote', ['error' => $e->getMessage()]);
        }

        return $stats;
    }

    private function getStats()
    {
        return [
            'total_properties' => Property::count(),
            'properties_with_translations' => Property::whereHas('translations')->count(),
            'last_sync' => Cache::get('inmovilla_web_sync_last_run'),
            'last_stats' => Cache::get('inmovilla_web_sync_last_stats')
        ];
    }
}