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
        // ===== APARTAMENTOS =====
        // Pisos, planta baja, dúplex, adosados y pareados
        199  => 'apartamento',    // Adosado ✅
        999  => 'apartamento',    // Pareado ✅
        2799 => 'apartamento',    // Apartamento ✅
        2999 => 'apartamento',    // Dúplex ✅
        3099 => 'apartamento',    // Estudio
        3199 => 'apartamento',    // Habitación
        3299 => 'apartamento',    // Loft
        3399 => 'apartamento',    // Piso ✅
        3499 => 'apartamento',    // Planta baja ✅
        3599 => 'apartamento',    // Triplex
        4899 => 'apartamento',    // Entresuelo
        9699 => 'apartamento',    // Piso Único
        
        // ===== ÁTICOS =====
        // Áticos y ático dúplex
        2899 => 'Ático',          // Ático ✅
        4399 => 'Ático',          // Ático Dúplex ✅
        4799 => 'Ático',          // Semiático
        20999 => 'Ático',         // Sobreático
        
        // ===== VILLAS/CASAS (se mostrará como Villa en frontend) =====
        // Villa, villa de lujo, chalet y casas
        299  => 'Casa',           // Bungalow
        399  => 'Casa',           // Casa
        499  => 'Casa',           // Chalet ✅
        599  => 'Casa',           // Cortijo
        699  => 'Casa',           // Hacienda
        899  => 'Casa',           // Masía
        1099 => 'Casa',           // Torre
        4599 => 'Casa',           // Casa de campo
        4699 => 'Casa',           // Buhardilla
        4999 => 'Casa',           // Villa ✅
        5199 => 'Casa',           // Quad House
        5299 => 'Casa',           // Sótano
        5499 => 'Casa',           // Bungalow Planta Alta
        5699 => 'Casa',           // Castillo
        5799 => 'Casa',           // Casa Cueva
        5999 => 'Casa',           // Casa de madera
        6099 => 'Casa',           // Caserío
        6199 => 'Casa',           // Casa Solar
        6299 => 'Casa',           // Casa de Pueblo
        6399 => 'Casa',           // Casita Agrícola
        6499 => 'Casa',           // Villa de Lujo ✅✅ ESTE ES EL QUE FALTABA
        6599 => 'Casa',           // Casa Terrera
        6699 => 'Casa',           // Pazo
        6899 => 'Casa',           // Casa de piedra
        7099 => 'Casa',           // Cabaña
        7499 => 'Casa',           // Bungalow Planta Baja
        7599 => 'Casa',           // Casa con terreno
        9499 => 'Casa',           // Vivienda sobre almacén
        10499 => 'Casa',          // Vivienda sobre Local
        10799 => 'Casa',          // Semisótano
        20099 => 'Casa',          // Mansión
        20299 => 'Casa',          // Alquería
        20699 => 'Casa',          // Residencia
        21199 => 'Casa',          // Casa Tipo Dúplex
        21299 => 'Casa',          // Caserón
        21399 => 'Casa',          // Palacio
        
        // ===== COMERCIALES → Casa (por defecto) =====
        1199 => 'Casa',           // Despacho
        1299 => 'Casa',           // Local comercial
        1399 => 'Casa',           // Oficina
        2399 => 'Casa',           // Garaje
        2599 => 'Casa',           // Parking
        2699 => 'Casa',           // Trastero
        9199 => 'Casa',           // Parking de moto
        
        // ===== TERRENOS Y FINCAS → Casa (por defecto) =====
        3699 => 'Casa',           // Finca rústica
        3799 => 'Casa',           // Monte
        3899 => 'Casa',           // Solar
        3999 => 'Casa',           // Terreno industrial
        4099 => 'Casa',           // Terreno rural
        4199 => 'Casa',           // Terreno urbano
        5099 => 'Casa',           // Parcela
        8699 => 'Casa',           // Olivar
        8799 => 'Casa',           // Tierra Calma
        8899 => 'Casa',           // Huerta
        8999 => 'Casa',           // Viñedo
        9099 => 'Casa',           // Terreno urbanizable
        10999 => 'Casa',          // Terreno Rústico
        11099 => 'Casa',          // Finca Agrícola
        11199 => 'Casa',          // Finca Ganadera
        11299 => 'Casa',          // Finca Cinegética
        11399 => 'Casa',          // Finca de Recreo
        11899 => 'Casa',          // Finca con Huerto
        20199 => 'Casa',          // Finca Mediterránea
        20399 => 'Casa',          // Coto de Caza
        20599 => 'Casa',          // Finca Urbana
        20899 => 'Casa',          // Solar Plurifamiliar
        
        // ===== NEGOCIOS Y HOTELERÍA → Casa (por defecto) =====
        1499 => 'Casa',           // Albergue
        1599 => 'Casa',           // Almacén
        1699 => 'Casa',           // Edificio
        1799 => 'Casa',           // Fábrica
        1899 => 'Casa',           // Hostal
        1999 => 'Casa',           // Hotel
        2099 => 'Casa',           // Nave industrial
        4499 => 'Casa',           // Negocio
        6799 => 'Casa',           // Camping
        7799 => 'Casa',           // Bar
        7899 => 'Casa',           // Restaurante
        7999 => 'Casa',           // Cafetería
        8299 => 'Casa',           // Discoteca
        9599 => 'Casa',           // Complejo Turístico
        9899 => 'Casa',           // Pub
        10199 => 'Casa',          // Gasolinera
        11499 => 'Casa',          // Almazara
        11599 => 'Casa',          // Hotel Rural
        11699 => 'Casa',          // Casa Rural
        11799 => 'Casa',          // Nave logística
        11999 => 'Casa',          // Centro Comercial
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