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
    // === MAPEO OPERACIONES INMOVILLA → LARAVEL (Solo 3) ===
    private $operationsMapping = [
        1 => 'Venta',        // keyacci 1 = Venta
        2 => 'Alquiler',     // keyacci 2 = Alquiler  
        3 => 'Venta',        // keyacci 3 = Traspaso → Venta
        4 => 'Alquiler',     // keyacci 4 = Leasing → Alquiler
    ];

    // === MAPEO TIPOS INMOVILLA → LARAVEL (Solo 3 tipos) ===
    private $propertyTypesMapping = [
        // APARTAMENTOS → apartamento
        2799 => 'apartamento',    // Apartamento
        2999 => 'apartamento',    // Duplex
        3099 => 'apartamento',    // Estudio
        3199 => 'apartamento',    // Habitación
        3299 => 'apartamento',    // Loft
        3399 => 'apartamento',    // Piso
        3499 => 'apartamento',    // Planta baja
        3599 => 'apartamento',    // Triplex
        
        // ÁTICOS → Ático
        2899 => 'Ático',          // Ático
        
        // VILLAS/CASAS → Casa (se mostrará como Villa en frontend)
        399  => 'Casa',           // Casa
        499  => 'Casa',           // Chalet
        199  => 'Casa',           // Adosado
        299  => 'Casa',           // Bungalow
        999  => 'Casa',           // Pareado
        4999 => 'Casa',           // Villa
        599  => 'Casa',           // Cortijo
        899  => 'Casa',           // Masía
        
        // COMERCIALES Y TERRENOS → Casa (por defecto)
        1299 => 'Casa',           // Local comercial
        1399 => 'Casa',           // Oficina
        2399 => 'Casa',           // Garaje
        2599 => 'Casa',           // Parking
        2699 => 'Casa',           // Trastero
        3699 => 'Casa',           // Finca rústica
        3899 => 'Casa',           // Solar
        4199 => 'Casa',           // Terreno urbano
    ];

    // === MAPEO ESTADOS CONSERVACIÓN INMOVILLA → LARAVEL (Solo 2) ===
    private $statusMapping = [
        5   => 'Disponible',
        10  => 'Disponible',
        15  => 'Disponible',
        20  => 'Disponible',
        30  => 'Disponible',
        40  => 'Disponible',
        50  => 'Disponible',
        60  => 'Disponible',
        70  => 'Disponible',
        80  => 'Disponible',
        90  => 'Reservado',
        100 => 'Reservado',
    ];

    public function __construct()
    {
        Log::info('InmovillaPropertyMapper inicializado');
    }

    /**
     * Mapea una propiedad de Inmovilla al formato híbrido Laravel + Inmovilla
     */
    public function mapProperty(array $inmovillaData): array
    {
        try {
            Log::info('Mapeando propiedad de Inmovilla', [
                'cod_ofer' => $inmovillaData['cod_ofer'] ?? 'N/A',
                'ref' => $inmovillaData['ref'] ?? 'N/A'
            ]);

            $mappedData = [
                // === CAMPOS LARAVEL OBLIGATORIOS ===
                'reference' => $this->getValue($inmovillaData, 'ref') ?: 'REF-' . ($inmovillaData['cod_ofer'] ?? rand(1000, 9999)),
                'operation_id' => $this->mapOperation($inmovillaData['keyacci'] ?? 1),
                'property_type_id' => $this->mapPropertyType($inmovillaData['key_tipo'] ?? 399),
                'status_id' => $this->mapStatus($inmovillaData['conservacion'] ?? 30),
                'is_featured' => (bool)($inmovillaData['destacado'] ?? false),
                'title' => $this->generateTitle($inmovillaData),
                'meta_description' => $this->generateMetaDescription($inmovillaData),
                'price' => $this->calculateMainPrice($inmovillaData),
                'slug' => $this->generateSlug($inmovillaData),
                
                // === CAMPOS MAPEO INTELIGENTE (evitar duplicidad) ===
                'built_area' => (int)($inmovillaData['m_cons'] ?? 0),
                'rooms' => $this->calculateTotalRooms($inmovillaData),
                'bathrooms' => (int)($inmovillaData['banyos'] ?? 0),
                'year_built' => (int)($inmovillaData['anoconstr'] ?? null),
                'floors' => (int)($inmovillaData['plantas'] ?? 1),
                'floor' => (int)($inmovillaData['planta'] ?? null),
                'distance_to_sea' => (int)($inmovillaData['distmar'] ?? null),
                'community_expenses' => $this->getValue($inmovillaData, 'gastos_com'),
                'parking_spaces' => (int)($inmovillaData['garajes'] ?? 0),
                'condition' => $this->mapCondition($inmovillaData['conservacion'] ?? 30),
                'orientation' => $this->mapOrientation($inmovillaData['keyori'] ?? null),
                'views' => $this->mapViews($inmovillaData['keyvista'] ?? null),
                'kitchen_type' => $this->mapKitchenType($inmovillaData['cocina_inde'] ?? null),
                'heating_type' => $this->mapHeatingType($inmovillaData['keycalefa'] ?? null),
                'interior_carpentry' => $this->mapCarpentry($inmovillaData['keycarpin'] ?? null),
                'exterior_carpentry' => $this->mapCarpentry($inmovillaData['keycarpinext'] ?? null),
                'flooring_type' => $this->mapFlooring($inmovillaData['keysuelo'] ?? null),
                'exterior_type' => $this->mapExteriorType($inmovillaData),
                'regime' => 'Freehold',
                'google_map' => null,
                'description' => $inmovillaData['descrip'] ?? '',
                'video' => null,
                
                // === TODOS LOS CAMPOS INMOVILLA (conservar datos originales) ===
                'cod_ofer' => (int)($inmovillaData['cod_ofer'] ?? 0),
                'inmovilla_ref' => $this->getValue($inmovillaData, 'ref'),
                'numagencia' => $this->getValue($inmovillaData, 'numagencia'),
                'fechaact' => $this->parseDate($inmovillaData['fechaact'] ?? null),
                'keyacci' => (int)($inmovillaData['keyacci'] ?? 1),
                'key_tipo' => (int)($inmovillaData['key_tipo'] ?? null),
                'nbtipo' => $this->getValue($inmovillaData, 'nbtipo'),
                'precioinmo' => $this->getValue($inmovillaData, 'precioinmo'),
                'precioalq' => $this->getValue($inmovillaData, 'precioalq'),
                'outlet' => $this->getValue($inmovillaData, 'outlet'),
                'tipomensual' => $this->getValue($inmovillaData, 'tipomensual'),
                'm_parcela' => (int)($inmovillaData['m_parcela'] ?? null),
                'm_uties' => (int)($inmovillaData['m_uties'] ?? null),
                'm_terraza' => (int)($inmovillaData['m_terraza'] ?? null),
                'habdobles' => (int)($inmovillaData['habdobles'] ?? null),
                'habitaciones_simples' => (int)($inmovillaData['habitaciones'] ?? null),
                'total_hab' => (int)($inmovillaData['total_hab'] ?? null),
                'aseos' => (int)($inmovillaData['aseos'] ?? null),
                'ascensor' => (bool)($inmovillaData['ascensor'] ?? false),
                'aire_con' => (bool)($inmovillaData['aire_con'] ?? false),
                'keyori' => (int)($inmovillaData['keyori'] ?? null),
                'keyvista' => (int)($inmovillaData['keyvista'] ?? null),
                'keyagua' => (int)($inmovillaData['keyagua'] ?? null),
                'keycalefa' => (int)($inmovillaData['keycalefa'] ?? null),
                'keycarpin' => (int)($inmovillaData['keycarpin'] ?? null),
                'keycarpinext' => (int)($inmovillaData['keycarpinext'] ?? null),
                'keysuelo' => (int)($inmovillaData['keysuelo'] ?? null),
                'keytecho' => (int)($inmovillaData['keytecho'] ?? null),
                'keyfachada' => (int)($inmovillaData['keyfachada'] ?? null),
                'keyelectricidad' => (int)($inmovillaData['keyelectricidad'] ?? null),
                'keypromo' => (int)($inmovillaData['keypromo'] ?? null),
            ];

            return $mappedData;
            
        } catch (Exception $e) {
            Log::error('Error mapeando propiedad de Inmovilla', [
                'cod_ofer' => $inmovillaData['cod_ofer'] ?? 'N/A',
                'error' => $e->getMessage(),
            ]);
            throw $e;
        }
    }

    // === MÉTODOS DE MAPEO ===

    private function mapOperation(int $keyacci): int
    {
        $operationName = $this->operationsMapping[$keyacci] ?? 'Venta';
        $operation = Operation::where('name', $operationName)->first();
        return $operation ? $operation->id : 1;
    }

    private function mapPropertyType(int $keyTipo): int
    {
        $typeName = $this->propertyTypesMapping[$keyTipo] ?? 'Casa';
        $propertyType = PropertyType::where('name', $typeName)->first();
        
        if (!$propertyType) {
            Log::warning("Tipo de propiedad no encontrado en BD: {$typeName} (keyTipo: {$keyTipo})");
            return 1; // Default: primer tipo disponible
        }
        
        return $propertyType->id;
    }

    private function mapStatus(int $conservacion): int
    {
        $statusName = $this->statusMapping[$conservacion] ?? 'Disponible';
        $status = Status::where('name', $statusName)->first();
        return $status ? $status->id : 1;
    }

    private function calculateMainPrice(array $data): float
    {
        $precioinmo = (float)($data['precioinmo'] ?? 0);
        $precioalq = (float)($data['precioalq'] ?? 0);
        return $precioinmo > 0 ? $precioinmo : $precioalq;
    }

    private function calculateTotalRooms(array $data): int
    {
        $habdobles = (int)($data['habdobles'] ?? 0);
        $habitaciones = (int)($data['habitaciones'] ?? 0);
        $totalHab = (int)($data['total_hab'] ?? 0);
        return $totalHab > 0 ? $totalHab : ($habdobles + $habitaciones);
    }

    private function generateTitle(array $data): string
    {
        $tipo = $data['nbtipo'] ?? 'Propiedad';
        $ciudad = $data['ciudad'] ?? '';
        $zona = $data['zona'] ?? '';
        return trim("{$tipo} en {$ciudad} {$zona}");
    }

    private function generateMetaDescription(array $data): string
    {
        $tipo = $data['nbtipo'] ?? 'Propiedad';
        $habitaciones = $data['total_hab'] ?? 0;
        $m2 = $data['m_cons'] ?? 0;
        return "{$tipo} de {$habitaciones} habitaciones y {$m2}m²";
    }

    private function generateSlug(array $data): string
    {
        $ref = $data['ref'] ?? 'property';
        $ciudad = $data['ciudad'] ?? '';
        return Str::slug("{$ref}-{$ciudad}");
    }

    private function getValue(array $data, string $key)
    {
        return $data[$key] ?? null;
    }

    private function parseDate($date)
    {
        if (empty($date)) return null;
        try {
            return \Carbon\Carbon::parse($date);
        } catch (Exception $e) {
            return null;
        }
    }

    private function mapCondition(int $conservacion): string
    {
        $conditions = [
            5 => 'Para reformar',
            10 => 'De origen',
            15 => 'Reformar parcialmente',
            20 => 'Entrar a vivir',
            30 => 'Buen estado',
            40 => 'Semireformado',
            50 => 'Reformado',
            60 => 'Seminuevo',
            70 => 'Nuevo',
            80 => 'Obra nueva',
            90 => 'En construcción',
            100 => 'En proyecto',
        ];
        return $conditions[$conservacion] ?? 'Buen estado';
    }

    private function mapOrientation($keyori): string
    {
        if (!$keyori) return 'No especificada';
        $orientations = [
            1 => 'Norte',
            2 => 'Sur',
            3 => 'Este',
            4 => 'Oeste',
            5 => 'Noreste',
            6 => 'Noroeste',
            7 => 'Sureste',
            8 => 'Suroeste',
        ];
        return $orientations[$keyori] ?? 'No especificada';
    }

    private function mapViews($keyvista): string
    {
        if (!$keyvista) return 'No especificadas';
        $views = [
            1 => 'Mar',
            2 => 'Montaña',
            3 => 'Golf',
            4 => 'Ciudad',
            5 => 'Piscina',
        ];
        return $views[$keyvista] ?? 'No especificadas';
    }

    private function mapKitchenType($cocina): string
    {
        return $cocina == 1 ? 'Independiente' : 'Americana';
    }

    private function mapHeatingType($keycalefa): string
    {
        if (!$keycalefa) return 'No especificado';
        $heating = [
            1 => 'Gas',
            2 => 'Eléctrica',
            3 => 'Bomba de calor',
        ];
        return $heating[$keycalefa] ?? 'No especificado';
    }

    private function mapCarpentry($key): string
    {
        if (!$key) return 'No especificado';
        $carpentry = [
            1 => 'Madera',
            2 => 'PVC',
            3 => 'Aluminio',
        ];
        return $carpentry[$key] ?? 'No especificado';
    }

    private function mapFlooring($keysuelo): string
    {
        if (!$keysuelo) return 'No especificado';
        $flooring = [
            1 => 'Baldosa',
            2 => 'Parquet',
            3 => 'Mármol',
        ];
        return $flooring[$keysuelo] ?? 'No especificado';
    }

    private function mapExteriorType($data): string
    {
        return 'No especificado';
    }
}