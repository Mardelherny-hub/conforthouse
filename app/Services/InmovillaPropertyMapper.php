<?php

namespace App\Services;

use App\Models\Property;
use App\Models\Address;
use App\Models\Operation;
use App\Models\PropertyType;
use App\Models\Status;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Exception;

class InmovillaPropertyMapper
{
    private $fieldMapping;
    private $operationsMapping;
    private $propertyTypesMapping;
    private $conditionsMapping;

    public function __construct()
    {
        $this->fieldMapping = config('inmovilla.field_mapping');
        $this->operationsMapping = $this->fieldMapping['keyacci']['mapping'] ?? [];
        $this->propertyTypesMapping = $this->fieldMapping['key_tipo']['mapping'] ?? [];
        $this->conditionsMapping = $this->fieldMapping['conservacion']['mapping'] ?? [];
        
        Log::info('InmovillaPropertyMapper inicializado');
    }

    /**
     * Mapea una propiedad de Inmovilla al formato de Laravel
     */
    public function mapProperty(array $inmovillaData): array
    {
        try {
            Log::info('Mapeando propiedad de Inmovilla', [
                'cod_ofer' => $inmovillaData['cod_ofer'] ?? 'N/A',
                'ref' => $inmovillaData['ref'] ?? 'N/A'
            ]);

            $mappedData = [
                // Campos básicos de identificación
                'reference' => $this->getValue($inmovillaData, 'ref'),
                'inmovilla_code' => $this->getValue($inmovillaData, 'cod_ofer'),
                'agency_code' => $this->getValue($inmovillaData, 'numagencia'),
                
                // Relaciones (IDs que se resolverán después)
                'operation_id' => $this->mapOperation($inmovillaData),
                'property_type_id' => $this->mapPropertyType($inmovillaData),
                'status_id' => $this->getDefaultStatusId(),
                
                // Precios
                'price' => $this->mapPrice($inmovillaData),
                'rental_price' => $this->getValue($inmovillaData, 'precioalq', 0),
                
                // Características básicas
                'rooms' => $this->getValue($inmovillaData, 'habitaciones', 0),
                'bathrooms' => $this->getValue($inmovillaData, 'banyos', 0),
                'built_area' => $this->getValue($inmovillaData, 'm_cons', 0),
                'usable_area' => $this->getValue($inmovillaData, 'm_uties', 0),
                'plot_area' => $this->getValue($inmovillaData, 'm_parcela', 0),
                'year_built' => $this->getValue($inmovillaData, 'anoconstr', null),
                'terrace_area' => $this->getValue($inmovillaData, 'm_terraza', 0),
                'floors' => $this->getValue($inmovillaData, 'plantas', 0),
                'floor' => $this->getValue($inmovillaData, 'planta', null), // Asumiendo que 'planta' es el campo
                'parking_spaces' => $this->getValue($inmovillaData, 'garajes', 0), // Asumiendo 'garajes'
                
                // Estado/condición
                'condition' => $this->mapCondition($inmovillaData),
                
                // Título y descripción (si están disponibles)
                'title' => $this->generateTitle($inmovillaData),
                'description' => $this->getValue($inmovillaData, 'descrip', null),
                'meta_description' => $this->generateMetaDescription($inmovillaData),
                
                // Campos adicionales de Inmovilla
                'community_expenses' => $this->getValue($inmovillaData, 'gastos_com', null), // Asumiendo 'gastos_com'
                'orientation' => $this->getValue($inmovillaData, 'orientacion', null),
                'exterior_type' => $this->getValue($inmovillaData, 'exterior', null),
                'kitchen_type' => $this->getValue($inmovillaData, 'cocina', null),
                'heating_type' => $this->getValue($inmovillaData, 'calefaccion', null),
                'interior_carpentry' => $this->getValue($inmovillaData, 'carp_interior', null),
                'exterior_carpentry' => $this->getValue($inmovillaData, 'carp_exterior', null),
                'flooring_type' => $this->getValue($inmovillaData, 'suelos', null),
                'views' => $this->getValue($inmovillaData, 'vistas', null),
                'regime' => $this->getValue($inmovillaData, 'regimen', null),
                'google_map' => $this->getValue($inmovillaData, 'google_map', null),
                'inmovilla_updated_at' => $this->getValue($inmovillaData, 'fechaact'),
                'photos_count' => $this->getValue($inmovillaData, 'numfotos', 0),
                'distance_to_sea' => $this->getValue($inmovillaData, 'distmar', 0),
                'elevator' => $this->getValue($inmovillaData, 'ascensor', 0),
                'air_conditioning' => $this->getValue($inmovillaData, 'aire_con', 0),
                'parking_included' => $this->mapParking($inmovillaData),
                'community_pool' => $this->getValue($inmovillaData, 'piscina_com', 0),
                'private_pool' => $this->getValue($inmovillaData, 'piscina_prop', 0),
                
                // Campos calculados
                'is_featured' => false, // Se actualizará según destacados
                'slug' => $this->generateSlug($inmovillaData),
            ];

            // Limpiar campos nulos o vacíos
            $mappedData = $this->cleanMappedData($mappedData);
            
            Log::info('Propiedad mapeada exitosamente', [
                'reference' => $mappedData['reference'],
                'operation_id' => $mappedData['operation_id'],
                'property_type_id' => $mappedData['property_type_id']
            ]);

            return $mappedData;

        } catch (Exception $e) {
            Log::error('Error mapeando propiedad de Inmovilla', [
                'cod_ofer' => $inmovillaData['cod_ofer'] ?? 'N/A',
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Mapea los datos de dirección de una propiedad de Inmovilla
     */
    /**
     * Mapea los datos de dirección de una propiedad de Inmovilla
     */
    public function mapAddress(array $inmovillaData): array
    {
        return [
            'street'                => $this->nullableStr($this->getValue($inmovillaData, 'direccion', '')),
            'city'                  => $this->nullableStr($this->getValue($inmovillaData, 'ciudad', '')),
            'district'              => $this->nullableStr($this->getValue($inmovillaData, 'zona', '')),
            'zone'                  => $this->nullableStr($this->getValue($inmovillaData, 'zona', '')), // persistimos también en addresses.zone
            'province'              => $this->nullableStr($this->getValue($inmovillaData, 'provincia', '')),
            'postal_code'           => $this->nullableStr($this->getValue($inmovillaData, 'cp', '')),
            'autonomous_community'  => null, // No viene en Inmovilla; lo derivaremos en otro paso
        ];
    }

    /**
     * Normaliza strings: trim; si queda vacío => null
     */
    private function nullableStr(?string $value): ?string
    {
        if ($value === null) {
            return null;
        }
        $v = trim($value);
        return $v === '' ? null : $v;
    }



    /**
     * Obtiene un valor del array de Inmovilla de forma segura
     */
    private function getValue(array $data, string $key, $default = null)
    {
        return $data[$key] ?? $default;
    }

    /**
     * Mapea la operación (keyacci) de Inmovilla a operation_id de Laravel
     */
    private function mapOperation(array $inmovillaData): ?int
    {
        $keyacci = $this->getValue($inmovillaData, 'keyacci');
        
        if (!$keyacci) {
            Log::warning('keyacci no encontrado en datos de Inmovilla');
            return null;
        }

        $operationName = $this->operationsMapping[$keyacci] ?? null;
        
        if (!$operationName) {
            Log::warning('Operación no mapeada', ['keyacci' => $keyacci]);
            return null;
        }

        // Buscar o crear la operación en Laravel
        $operation = Operation::where('name', $operationName)->first();
        
        if (!$operation) {
            Log::info('Creando nueva operación', ['name' => $operationName]);
            $operation = Operation::create(['name' => $operationName]);
        }

        return $operation->id;
    }

    /**
     * Mapea el tipo de propiedad (key_tipo) de Inmovilla a property_type_id de Laravel
     */
    private function mapPropertyType(array $inmovillaData): ?int
    {
        // Primero intentar con key_tipo
        $keyTipo = $this->getValue($inmovillaData, 'key_tipo');
        
        if ($keyTipo && isset($this->propertyTypesMapping[$keyTipo])) {
            $typeName = $this->propertyTypesMapping[$keyTipo];
        } else {
            // Si no existe key_tipo, usar nbtipo (nombre del tipo)
            $typeName = $this->getValue($inmovillaData, 'nbtipo');
        }

        if (!$typeName) {
            Log::warning('Tipo de propiedad no encontrado en datos de Inmovilla');
            return null;
        }

        // Buscar o crear el tipo de propiedad en Laravel
        $propertyType = PropertyType::where('name', $typeName)->first();
        
        if (!$propertyType) {
            Log::info('Creando nuevo tipo de propiedad', ['name' => $typeName]);
            $propertyType = PropertyType::create(['name' => $typeName]);
        }

        return $propertyType->id;
    }

    /**
     * Mapea el precio según el tipo de operación
     */
    private function mapPrice(array $inmovillaData): float
    {
        $keyacci = $this->getValue($inmovillaData, 'keyacci');
        
        // Si es venta (1) o venta/alquiler (4), usar precioinmo
        if (in_array($keyacci, [1, 4, 5, 7, 13, 14])) {
            return (float) $this->getValue($inmovillaData, 'precioinmo', 0);
        }
        
        // Si es solo alquiler (2), usar precioalq
        if (in_array($keyacci, [2, 6, 9, 15])) {
            return (float) $this->getValue($inmovillaData, 'precioalq', 0);
        }
        
        // Por defecto, usar precioinmo
        return (float) $this->getValue($inmovillaData, 'precioinmo', 0);
    }

    /**
     * Mapea la condición/conservación de la propiedad
     */
    private function mapCondition(array $inmovillaData): string
    {
        $conservacion = $this->getValue($inmovillaData, 'conservacion');
        
        if ($conservacion && isset($this->conditionsMapping[$conservacion])) {
            return $this->conditionsMapping[$conservacion];
        }
        
        return 'Buen estado'; // Valor por defecto
    }

    /**
     * Mapea el parking según los valores de Inmovilla
     */
    private function mapParking(array $inmovillaData): int
    {
        $parking = $this->getValue($inmovillaData, 'parking', 0);
        
        // Inmovilla: 0=No tiene, 1=Opcional, 2=Incluido
        // Laravel: 0=No, 1=Sí
        return $parking > 0 ? 1 : 0;
    }

    /**
     * Genera un título para la propiedad si no viene de Inmovilla
     */
    private function generateTitle(array $inmovillaData): string
    {
        $titulo = $this->getValue($inmovillaData, 'titulo');
        
        if ($titulo) {
            return $titulo;
        }

        // Generar título automático
        $tipo = $this->getValue($inmovillaData, 'nbtipo', 'Propiedad');
        $ciudad = $this->getValue($inmovillaData, 'ciudad', '');
        $zona = $this->getValue($inmovillaData, 'zona', '');
        
        $title = $tipo;
        if ($zona) {
            $title .= " en $zona";
        } elseif ($ciudad) {
            $title .= " en $ciudad";
        }
        
        return $title;
    }

    /**
     * Genera meta descripción para SEO
     */
    private function generateMetaDescription(array $inmovillaData): string
    {
        $tipo = $this->getValue($inmovillaData, 'nbtipo', 'Propiedad');
        $ciudad = $this->getValue($inmovillaData, 'ciudad', '');
        $habitaciones = $this->getValue($inmovillaData, 'habitaciones', 0);
        $metros = $this->getValue($inmovillaData, 'm_cons', 0);
        $precio = $this->getValue($inmovillaData, 'precioinmo', 0);
        
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

    /**
     * Genera slug único para la propiedad
     */
    private function generateSlug(array $inmovillaData): string
    {
        $title = $this->generateTitle($inmovillaData);
        $baseSlug = Str::slug($title);
        $ref = $this->getValue($inmovillaData, 'ref', '');
        
        // Agregar referencia para unicidad
        if ($ref) {
            $baseSlug .= '-' . Str::slug($ref);
        }
        
        return $baseSlug;
    }

    /**
     * Obtiene el ID del estado por defecto (Disponible)
     */
    private function getDefaultStatusId(): int
    {
        $status = Status::where('name', 'Disponible')->first();
        
        if (!$status) {
            Log::info('Creando estado Disponible por defecto');
            $status = Status::create(['name' => 'Disponible']);
        }
        
        return $status->id;
    }

    /**
     * Limpia los datos mapeados eliminando valores nulos o vacíos no deseados
     */
    private function cleanMappedData(array $data): array
    {
        // Campos que pueden ser nulos
        $nullableFields = ['rental_price', 'plot_area', 'terrace_area', 'usable_area'];
        
        foreach ($data as $key => $value) {
            // Mantener campos nullable aunque sean 0
            if (in_array($key, $nullableFields)) {
                continue;
            }
            
            // Limpiar strings vacíos
            if (is_string($value) && trim($value) === '') {
                $data[$key] = null;
            }
            
            // Convertir 0 a null para campos que no deberían ser 0
            if (in_array($key, ['operation_id', 'property_type_id', 'status_id']) && $value === 0) {
                $data[$key] = null;
            }
        }
        
        return $data;
    }

    /**
     * Mapea un lote de propiedades de Inmovilla
     */
    public function mapPropertiesBatch(array $inmovillaProperties): array
    {
        $mappedProperties = [];
        
        Log::info('Mapeando lote de propiedades', ['count' => count($inmovillaProperties)]);
        
        foreach ($inmovillaProperties as $inmovillaProperty) {
            try {
                $mappedProperty = $this->mapProperty($inmovillaProperty);
                $mappedProperties[] = $mappedProperty;
            } catch (Exception $e) {
                Log::error('Error mapeando propiedad en lote', [
                    'cod_ofer' => $inmovillaProperty['cod_ofer'] ?? 'N/A',
                    'error' => $e->getMessage()
                ]);
                // Continuar con la siguiente propiedad
                continue;
            }
        }
        
        Log::info('Lote de propiedades mapeado', [
            'total_input' => count($inmovillaProperties),
            'total_mapped' => count($mappedProperties),
            'errors' => count($inmovillaProperties) - count($mappedProperties)
        ]);
        
        return $mappedProperties;
    }
}