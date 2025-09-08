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
                // === IDENTIFICACIÓN INMOVILLA (campos de la migración) ===
                'reference' => $this->getValue($inmovillaData, 'ref') ?: 'REF-' . $this->getValue($inmovillaData, 'cod_ofer'),
                'cod_ofer' => $this->getValue($inmovillaData, 'cod_ofer'),
                'inmovilla_numagencia' => $this->getValue($inmovillaData, 'numagencia'),
                'inmovilla_ref' => $this->getValue($inmovillaData, 'ref'),
                'inmovilla_fechaact' => $this->getValue($inmovillaData, 'fechaact'),
                
                // === TIPO Y OPERACIÓN ===
                'inmovilla_keyacci' => $this->getValue($inmovillaData, 'keyacci'),
                'inmovilla_key_tipo' => $this->getValue($inmovillaData, 'key_tipo'),
                
                // === PRECIOS ===
                'price' => $this->mapPrice($inmovillaData),
                'price_sale' => $this->getValue($inmovillaData, 'precioinmo', 0),
                'price_rent' => $this->getValue($inmovillaData, 'precioalq', 0),
                'price_outlet' => $this->getValue($inmovillaData, 'outlet', 0),
                'rent_period' => $this->getValue($inmovillaData, 'tipomensual'),
                
                // === MEDIDAS ===
                'built_area' => $this->getValue($inmovillaData, 'm_cons', 0),
                'plot_area_m2' => $this->getValue($inmovillaData, 'm_parcela', 0),
                'useful_area_m2' => $this->getValue($inmovillaData, 'm_uties', 0),
                'built_area_m2' => $this->getValue($inmovillaData, 'm_cons', 0),
                'terrace_area_m2' => $this->getValue($inmovillaData, 'm_terraza', 0),
                
                // === HABITACIONES Y BAÑOS ===
                'rooms' => $this->getValue($inmovillaData, 'habitaciones', 0),
                'double_rooms' => $this->getValue($inmovillaData, 'habdobles', 0),
                'single_rooms' => $this->getValue($inmovillaData, 'habitaciones', 0),
                'total_rooms' => $this->getValue($inmovillaData, 'total_hab', 0),
                'bathrooms' => $this->getValue($inmovillaData, 'banyos', 0),
                'toilets' => $this->getValue($inmovillaData, 'aseos', 0),
                
                // === CARACTERÍSTICAS BÁSICAS ===
                'has_elevator' => (bool) $this->getValue($inmovillaData, 'ascensor', 0),
                'has_air_conditioning' => (bool) $this->getValue($inmovillaData, 'aire_con', 0),
                'has_heating' => (bool) $this->getValue($inmovillaData, 'calefaccion', 0),
                'parking_type' => $this->getValue($inmovillaData, 'parking', 0),
                'parking_spaces' => $this->getValue($inmovillaData, 'garajes', 0),
                'has_community_pool' => (bool) $this->getValue($inmovillaData, 'piscina_com', 0),
                'has_private_pool' => (bool) $this->getValue($inmovillaData, 'piscina_prop', 0),
                'is_diaphanous' => (bool) $this->getValue($inmovillaData, 'diafano', 0),
                'is_all_exterior' => (bool) $this->getValue($inmovillaData, 'todoext', 0),
                'distance_to_sea' => $this->getValue($inmovillaData, 'distmar', 0),
                
                // === CERTIFICACIÓN ENERGÉTICA ===
                'energy_certificate_letter' => $this->getValue($inmovillaData, 'energialetra'),
                'energy_consumption_value' => $this->getValue($inmovillaData, 'energiavalor'),
                'emissions_certificate_letter' => $this->getValue($inmovillaData, 'emisionesletra'),
                'emissions_value' => $this->getValue($inmovillaData, 'emisionesvalor'),
                
                // === CAMPOS ENUM DE INMOVILLA ===
                'inmovilla_conservacion' => $this->getValue($inmovillaData, 'conservacion'),
                'inmovilla_cocina_inde' => $this->getValue($inmovillaData, 'cocina_inde'),
                'inmovilla_keyori' => $this->getValue($inmovillaData, 'keyori'),
                'inmovilla_keyvista' => $this->getValue($inmovillaData, 'keyvista'),
                'inmovilla_keyagua' => $this->getValue($inmovillaData, 'keyagua'),
                'inmovilla_keycalefa' => $this->getValue($inmovillaData, 'keycalefa'),
                'inmovilla_keycarpin' => $this->getValue($inmovillaData, 'keycarpin'),
                'inmovilla_keycarpinext' => $this->getValue($inmovillaData, 'keycarpinext'),
                'inmovilla_keysuelo' => $this->getValue($inmovillaData, 'keysuelo'),
                'inmovilla_keytecho' => $this->getValue($inmovillaData, 'keytecho'),
                'inmovilla_keyfachada' => $this->getValue($inmovillaData, 'keyfachada'),
                'inmovilla_keyelectricidad' => $this->getValue($inmovillaData, 'keyelectricidad'),
                'inmovilla_x_entorno' => $this->getValue($inmovillaData, 'x_entorno'),
                
                // === OTROS CAMPOS INMOVILLA ===
                'inmovilla_tipovpo' => $this->getValue($inmovillaData, 'tipovpo'),
                'inmovilla_electro' => $this->getValue($inmovillaData, 'electro'),
                'inmovilla_destacado' => $this->getValue($inmovillaData, 'destacado'),
                'inmovilla_estadoficha' => $this->getValue($inmovillaData, 'estadoficha'),
                'inmovilla_eninternet' => $this->getValue($inmovillaData, 'eninternet'),
                'inmovilla_tgascom' => $this->getValue($inmovillaData, 'tgascom'),
                
                // === MULTIMEDIA ===
                'photo_count' => $this->getValue($inmovillaData, 'numfotos', 0),
                'main_photo_url' => $this->getValue($inmovillaData, 'foto'),
                'has_virtual_tour' => (bool) $this->getValue($inmovillaData, 'tourvirtual', 0),
                'has_360_photos' => (bool) $this->getValue($inmovillaData, 'fotos360', 0),
                'has_video_content' => (bool) $this->getValue($inmovillaData, 'video', 0),
                'has_before_after_photos' => (bool) $this->getValue($inmovillaData, 'antesydespues', 0),
                'photo_letter_id' => $this->getValue($inmovillaData, 'fotoletra'),
                
                // === INFORMACIÓN DE AGENCIA ===
                'agency_name' => $this->getValue($inmovillaData, 'agencia'),
                'agency_website' => $this->getValue($inmovillaData, 'web'),
                'agency_email' => $this->getValue($inmovillaData, 'emailagencia'),
                'agency_phone' => $this->getValue($inmovillaData, 'telefono'),
                
                // === UBICACIÓN DE INMOVILLA ===
                'inmovilla_ciudad' => $this->getValue($inmovillaData, 'ciudad'),
                'inmovilla_zona' => $this->getValue($inmovillaData, 'zona'),
                'inmovilla_key_loca' => $this->getValue($inmovillaData, 'key_loca'),
                'inmovilla_key_zona' => $this->getValue($inmovillaData, 'key_zona'),
                'inmovilla_keypromo' => $this->getValue($inmovillaData, 'keypromo'),
                
                // === CAMPOS EXISTENTES MANTENIDOS ===
                'floors' => $this->getValue($inmovillaData, 'plantas', 0),
                'floor' => $this->getValue($inmovillaData, 'planta'),
                'year_built' => $this->getValue($inmovillaData, 'anio_const'),
                'community_expenses' => $this->getValue($inmovillaData, 'gastos_com'),
                
                // === CAMPOS OBLIGATORIOS ===
                'operation_id' => $this->mapOperation($inmovillaData),
                'property_type_id' => $this->mapPropertyType($inmovillaData),
                'status_id' => $this->getDefaultStatusId(),
                'title' => $this->generateTitle($inmovillaData),
                'meta_description' => $this->generateMetaDescription($inmovillaData),
                'condition' => $this->mapCondition($inmovillaData),
                'is_featured' => false,
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