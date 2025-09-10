<?php

namespace App\Services;

use App\Models\Property;
use App\Models\PropertyTranslation;
use App\Helpers\LibreTranslateHelper;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Exception;

class BatchTranslationService
{
    private $supportedLanguages = ['en', 'fr', 'de'];
    private $batchSize = 10;
    private $delayBetweenBatches = 2; // segundos
    private $maxRetries = 2;

    public function __construct()
    {
        $this->batchSize = config('inmovilla.sync.batch_size', 10);
    }

    /**
     * Traduce todas las propiedades sin traducir
     */
    public function translateAllProperties($startFromId = null): array
    {
        $stats = [
            'processed' => 0,
            'translated' => 0,
            'skipped' => 0,
            'errors' => 0
        ];

        // Obtener propiedades que necesitan traducción
        $query = Property::whereDoesntHave('translations');
        
        if ($startFromId) {
            $query->where('id', '>=', $startFromId);
        }

        $properties = $query->orderBy('id')->get();

        if ($properties->isEmpty()) {
            Log::info('No hay propiedades para traducir');
            return $stats;
        }

        Log::info('Iniciando traducción en lotes', [
            'total_properties' => $properties->count(),
            'languages' => $this->supportedLanguages,
            'batch_size' => $this->batchSize
        ]);

        // Procesar en lotes
        $batches = $properties->chunk($this->batchSize);
        
        foreach ($batches as $batchIndex => $batch) {
            Log::info("Procesando lote " . ($batchIndex + 1) . " de " . $batches->count());
            
            foreach ($batch as $property) {
                $result = $this->translateProperty($property);
                
                $stats['processed']++;
                if ($result['success']) {
                    $stats['translated']++;
                } elseif ($result['skipped']) {
                    $stats['skipped']++;
                } else {
                    $stats['errors']++;
                }
            }

            // Pausa entre lotes para no sobrecargar LibreTranslate
            if ($batchIndex < $batches->count() - 1) {
                sleep($this->delayBetweenBatches);
            }
        }

        return $stats;
    }

    /**
     * Traduce una propiedad específica a todos los idiomas
     */
    public function translateProperty(Property $property): array
    {
        $result = [
            'success' => false,
            'skipped' => false,
            'translations_created' => 0,
            'errors' => []
        ];

        try {
            // Verificar si ya tiene traducciones
            if ($property->translations()->exists()) {
                $result['skipped'] = true;
                return $result;
            }

            // Campos a traducir
            $fieldsToTranslate = [
                'title' => $property->title,
                'description' => $property->description,
                'meta_description' => $property->meta_description,
                'condition' => $property->condition,
                'orientation' => $property->orientation,
                'exterior_type' => $property->exterior_type,
                'kitchen_type' => $property->kitchen_type,
                'heating_type' => $property->heating_type,
                'interior_carpentry' => $property->interior_carpentry,
                'exterior_carpentry' => $property->exterior_carpentry,
                'flooring_type' => $property->flooring_type,
                'views' => $property->views,
                'regime' => $property->regime
            ];

            // Traducir a cada idioma
            foreach ($this->supportedLanguages as $locale) {
                $translatedFields = [];
                $hasErrors = false;

                foreach ($fieldsToTranslate as $field => $text) {
                    if (empty($text)) {
                        $translatedFields[$field] = null;
                        continue;
                    }

                    try {
                        $translatedText = LibreTranslateHelper::translate($text, 'es', $locale);
                        $translatedFields[$field] = $translatedText;
                        
                        // Pequeña pausa entre traducciones para no saturar
                        usleep(100000); // 0.1 segundos
                        
                    } catch (Exception $e) {
                        Log::warning("Error traduciendo campo {$field} para propiedad {$property->id}", [
                            'locale' => $locale,
                            'error' => $e->getMessage()
                        ]);
                        
                        $translatedFields[$field] = $text; // Mantener texto original
                        $hasErrors = true;
                        $result['errors'][] = "Error en {$field} ({$locale}): " . $e->getMessage();
                    }
                }

                // Crear traducción
                try {
                    PropertyTranslation::create([
                        'property_id' => $property->id,
                        'locale' => $locale,
                        'title' => $translatedFields['title'],
                        'description' => $translatedFields['description'],
                        'meta_description' => $translatedFields['meta_description'],
                        'condition' => $translatedFields['condition'],
                        'orientation' => $translatedFields['orientation'],
                        'exterior_type' => $translatedFields['exterior_type'],
                        'kitchen_type' => $translatedFields['kitchen_type'],
                        'heating_type' => $translatedFields['heating_type'],
                        'interior_carpentry' => $translatedFields['interior_carpentry'],
                        'exterior_carpentry' => $translatedFields['exterior_carpentry'],
                        'flooring_type' => $translatedFields['flooring_type'],
                        'views' => $translatedFields['views'],
                        'regime' => $translatedFields['regime'],
                    ]);

                    $result['translations_created']++;
                    
                } catch (Exception $e) {
                    Log::error("Error creando traducción para propiedad {$property->id}", [
                        'locale' => $locale,
                        'error' => $e->getMessage()
                    ]);
                    $result['errors'][] = "Error creando traducción ({$locale}): " . $e->getMessage();
                }
            }

            $result['success'] = $result['translations_created'] > 0;

        } catch (Exception $e) {
            Log::error("Error general traduciendo propiedad {$property->id}", [
                'error' => $e->getMessage()
            ]);
            $result['errors'][] = "Error general: " . $e->getMessage();
        }

        return $result;
    }

    /**
     * Verifica si LibreTranslate está disponible
     */
    public function isTranslationServiceAvailable(): bool
    {
        return LibreTranslateHelper::isServiceAvailable();
    }

    /**
     * Obtiene estadísticas de traducción
     */
    public function getTranslationStats(): array
    {
        $totalProperties = Property::count();
        $propertiesWithTranslations = Property::whereHas('translations')->count();
        $propertiesWithoutTranslations = $totalProperties - $propertiesWithTranslations;

        return [
            'total_properties' => $totalProperties,
            'properties_with_translations' => $propertiesWithTranslations,
            'properties_without_translations' => $propertiesWithoutTranslations,
            'translation_coverage' => $totalProperties > 0 ? round(($propertiesWithTranslations / $totalProperties) * 100, 2) : 0
        ];
    }
}