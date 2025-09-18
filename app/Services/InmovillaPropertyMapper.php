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
    // === MAPEO OPERACIONES INMOVILLA → LARAVEL ===
    private $operationsMapping = [
        1 => 'Venta',        // keyacci 1 = Venta
        2 => 'Alquiler',     // keyacci 2 = Alquiler  
        3 => 'Traspaso',     // keyacci 3 = Traspaso
        4 => 'Leasing',      // keyacci 4 = Leasing (si existe)
    ];

    // === MAPEO TIPOS INMOVILLA → LARAVEL ===
    private $propertyTypesMapping = [
        // Apartamentos y pisos
        2799 => 'apartamento',    // Apartamento
        2899 => 'Ático',           // Ático
        2999 => 'apartamento',    // Duplex → apartamento
        3099 => 'apartamento',    // Estudio → apartamento
        3199 => 'apartamento',    // Habitación → apartamento
        3299 => 'apartamento',    // Loft → apartamento
        3399 => 'apartamento',    // Piso → apartamento
        3499 => 'apartamento',    // Planta baja → apartamento
        3599 => 'apartamento',    // Triplex → apartamento
        
        // Casas
        399  => 'Casa',            // Casa
        499  => 'Casa',            // Chalet → Casa
        199  => 'Adosado',         // Adosado
        299  => 'Casa',            // Bungalow → Casa
        999  => 'Casa',            // Pareado → Casa
        4999 => 'Casa',            // Villa → Casa
        599  => 'Casa',            // Cortijo → Casa
        899  => 'Casa',            // Masía → Casa
        
        // Comerciales (mapear a Casa por defecto si no existe tipo comercial)
        1299 => 'Casa',            // Local comercial → Casa
        1399 => 'Casa',            // Oficina → Casa
        2399 => 'Casa',            // Garaje → Casa
        2599 => 'Casa',            // Parking → Casa
        2699 => 'Casa',            // Trastero → Casa
        
        // Terrenos
        3699 => 'Casa',            // Finca rústica → Casa
        3899 => 'Casa',            // Solar → Casa
        4199 => 'Casa',            // Terreno urbano → Casa
    ];

    // === MAPEO ESTADOS CONSERVACIÓN INMOVILLA → LARAVEL ===
    private $statusMapping = [
        5   => 'Disponible',    // Para reformar → Disponible
        10  => 'Disponible',    // De origen → Disponible
        15  => 'Disponible',    // Reformar parcialmente → Disponible
        20  => 'Disponible',    // Entrar a vivir → Disponible
        30  => 'Disponible',    // Buen estado → Disponible
        40  => 'Disponible',    // Semireformado → Disponible
        50  => 'Disponible',    // Reformado → Disponible
        60  => 'Disponible',    // Seminuevo → Disponible
        70  => 'Disponible',    // Nuevo → Disponible
        80  => 'Disponible',    // Obra nueva → Disponible
        90  => 'Reservado',     // En construcción → Reservado
        100 => 'Reservado',     // En proyecto → Reservado
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
                'regime' => 'Freehold', // Valor por defecto
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
                'calefaccion' => (bool)($inmovillaData['calefaccion'] ?? false),
                'parking' => (int)($inmovillaData['parking'] ?? null),
                'piscina_com' => (bool)($inmovillaData['piscina_com'] ?? false),
                'piscina_prop' => (bool)($inmovillaData['piscina_prop'] ?? false),
                'diafano' => (bool)($inmovillaData['diafano'] ?? false),
                'todoext' => (bool)($inmovillaData['todoext'] ?? false),
                'anoconstr' => (int)($inmovillaData['anoconstr'] ?? null),
                'garajes' => (int)($inmovillaData['garajes'] ?? null),
                'energialetra' => $this->getValue($inmovillaData, 'energialetra'),
                'energiavalor' => (float)($inmovillaData['energiavalor'] ?? null),
                'emisionesletra' => $this->getValue($inmovillaData, 'emisionesletra'),
                'emisionesvalor' => (float)($inmovillaData['emisionesvalor'] ?? null),
                'conservacion' => (int)($inmovillaData['conservacion'] ?? null),
                'cocina_inde' => (int)($inmovillaData['cocina_inde'] ?? null),
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
                'x_entorno' => (int)($inmovillaData['x_entorno'] ?? null),
                'tipovpo' => (int)($inmovillaData['tipovpo'] ?? null),
                'electro' => (int)($inmovillaData['electro'] ?? null),
                'destacado' => (int)($inmovillaData['destacado'] ?? null),
                'estadoficha' => (int)($inmovillaData['estadoficha'] ?? null),
                'eninternet' => (int)($inmovillaData['eninternet'] ?? null),
                'tgascom' => (int)($inmovillaData['tgascom'] ?? null),
                'numfotos' => (int)($inmovillaData['numfotos'] ?? 0),
                'foto' => $this->getValue($inmovillaData, 'foto'),
                'tourvirtual' => (bool)($inmovillaData['tourvirtual'] ?? false),
                'fotos360' => (bool)($inmovillaData['fotos360'] ?? false),
                'video_inmovilla' => (bool)($inmovillaData['video'] ?? false),
                'antesydespues' => (bool)($inmovillaData['antesydespues'] ?? false),
                'fotoletra' => $this->getValue($inmovillaData, 'fotoletra'),
                'agencia' => $this->getValue($inmovillaData, 'agencia'),
                'web' => $this->getValue($inmovillaData, 'web'),
                'emailagencia' => $this->getValue($inmovillaData, 'emailagencia'),
                'telefono' => $this->getValue($inmovillaData, 'telefono'),
                'ciudad_inmovilla' => $this->getValue($inmovillaData, 'ciudad'),
                'zona_inmovilla' => $this->getValue($inmovillaData, 'zona'),
                'key_loca' => (int)($inmovillaData['key_loca'] ?? null),
                'key_zona' => (int)($inmovillaData['key_zona'] ?? null),
                'keypromo' => (int)($inmovillaData['keypromo'] ?? null),
            ];

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
     * Mapea direcciones de Inmovilla
     */
    public function mapAddress(array $inmovillaData): array
    {
        return [
            'street' => $this->getValue($inmovillaData, 'direccion') ?: 'Sin dirección',
            'city' => $this->getValue($inmovillaData, 'ciudad') ?: 'Sin ciudad',
            'district' => $this->getValue($inmovillaData, 'zona'),
            'province' => $this->getValue($inmovillaData, 'provincia'),
            'postal_code' => $this->getValue($inmovillaData, 'cp'),
            'autonomous_community' => null,
            
            // Campos adicionales Inmovilla
            'inmovilla_direccion' => $this->getValue($inmovillaData, 'direccion'),
            'inmovilla_cp' => $this->getValue($inmovillaData, 'cp'),
            'inmovilla_provincia' => $this->getValue($inmovillaData, 'provincia'),
        ];
    }

    // === MÉTODOS DE MAPEO ===

    private function mapOperation(int $keyacci): int
    {
        $operationName = $this->operationsMapping[$keyacci] ?? 'Venta';
        $operation = Operation::where('name', $operationName)->first();
        return $operation ? $operation->id : 1; // Default: Venta
    }

    private function mapPropertyType(int $keyTipo): int
    {
        $typeName = $this->propertyTypesMapping[$keyTipo] ?? 'Casa';
        $propertyType = PropertyType::where('name', $typeName)->first();
        return $propertyType ? $propertyType->id : 1; // Default: Casa
    }

    private function mapStatus(int $conservacion): int
    {
        $statusName = $this->statusMapping[$conservacion] ?? 'Disponible';
        $status = Status::where('name', $statusName)->first();
        return $status ? $status->id : 1; // Default: Disponible
    }

    private function calculateMainPrice(array $data): float
    {
        $precioinmo = (float)($data['precioinmo'] ?? 0);
        $precioalq = (float)($data['precioalq'] ?? 0);
        
        // Priorizar precio venta, luego alquiler
        return $precioinmo > 0 ? $precioinmo : $precioalq;
    }

    private function calculateTotalRooms(array $data): int
    {
        $habdobles = (int)($data['habdobles'] ?? 0);
        $habitaciones = (int)($data['habitaciones'] ?? 0);
        $totalHab = (int)($data['total_hab'] ?? 0);
        
        // Usar total_hab si está disponible, sino sumar dobles + simples
        return $totalHab > 0 ? $totalHab : ($habdobles + $habitaciones);
    }

    private function generateTitle(array $data): string
    {
        $tipo = $data['nbtipo'] ?? 'Propiedad';
        $ciudad = $data['ciudad'] ?? '';
        $zona = $data['zona'] ?? '';
        
        $title = $tipo;
        if ($zona) {
            $title .= " en $zona";
        } elseif ($ciudad) {
            $title .= " en $ciudad";
        }
        
        return $title;
    }

    private function generateMetaDescription(array $data): string
    {
        $tipo = $data['nbtipo'] ?? 'Propiedad';
        $ciudad = $data['ciudad'] ?? '';
        $habitaciones = $this->calculateTotalRooms($data);
        $metros = (int)($data['m_cons'] ?? 0);
        $precio = $this->calculateMainPrice($data);
        
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

    private function generateSlug(array $data): string
    {
        $title = $this->generateTitle($data);
        return Str::slug($title) . '-' . ($data['cod_ofer'] ?? rand(1000, 9999));
    }

    private function mapCondition(int $conservacion): string
    {
        $conditions = [
            5 => 'Needs Renovation',
            10 => 'Original',
            15 => 'Partial Renovation',
            20 => 'Move-in Ready',
            30 => 'Good',
            40 => 'Semi-renovated',
            50 => 'Renovated',
            60 => 'Semi-new',
            70 => 'New',
            80 => 'New Build',
            90 => 'Under Construction',
            100 => 'In Project',
        ];
        
        return $conditions[$conservacion] ?? 'Good';
    }

    private function mapOrientation(int $keyori = null): string
    {
        if (!$keyori) return 'South';
        
        $orientations = [
            1 => 'North',
            2 => 'South', 
            3 => 'East',
            4 => 'West',
            5 => 'Northwest',
            6 => 'Southwest',
            7 => 'East-West',
            8 => 'Southeast',
            9 => 'North-South',
            10 => 'Northeast',
        ];
        
        return $orientations[$keyori] ?? 'South';
    }

    private function mapViews(int $keyvista = null): string
    {
        if (!$keyvista) return 'City';
        
        // Simplificado - se puede expandir según API
        return $keyvista === 1 ? 'Sea' : 'City';
    }

    private function mapKitchenType(int $cocinaInde = null): string
    {
        if (!$cocinaInde) return 'Independent';
        
        $kitchens = [
            1 => 'Independent',
            2 => 'American',
            3 => 'Open Concept',
        ];
        
        return $kitchens[$cocinaInde] ?? 'Independent';
    }

    private function mapHeatingType(int $keycalefa = null): string
    {
        if (!$keycalefa) return 'Gas';
        
        $heating = [
            1 => 'Gas',
            2 => 'Electric',
            3 => 'Solar',
        ];
        
        return $heating[$keycalefa] ?? 'Gas';
    }

    private function mapCarpentry(int $keycarp = null): string
    {
        if (!$keycarp) return 'Wood';
        
        $carpentry = [
            1 => 'Wood',
            2 => 'PVC',
            3 => 'Aluminum',
        ];
        
        return $carpentry[$keycarp] ?? 'Wood';
    }

    private function mapFlooring(int $keysuelo = null): string
    {
        if (!$keysuelo) return 'Tile';
        
        $flooring = [
            1 => 'Marble',
            2 => 'Parquet',
            3 => 'Parquet',
            4 => 'Marble',
            5 => 'Tile',
            6 => 'Tile',
            7 => 'Tile',
            8 => 'Tile',
            9 => 'Parquet',
            10 => 'Tile',
            11 => 'Tile',
            12 => 'Tile',
        ];
        
        return $flooring[$keysuelo] ?? 'Tile';
    }

    private function mapExteriorType(array $data): string
    {
        return ($data['todoext'] ?? false) ? 'Open' : 'Closed';
    }

    private function parseDate($date): ?string
    {
        if (!$date) return null;
        
        try {
            return \Carbon\Carbon::parse($date)->format('Y-m-d H:i:s');
        } catch (Exception $e) {
            Log::warning('Error parsing date', ['date' => $date, 'error' => $e->getMessage()]);
            return null;
        }
    }

    private function getValue(array $data, string $key)
    {
        $value = $data[$key] ?? null;
        return (!empty($value) && $value !== 'NULL' && $value !== '') ? $value : null;
    }
}