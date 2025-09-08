<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Exception;

class InmovillaApiService
{
    private $numagencia;
    private $password;
    private $idioma;
    private $rateLimitRequests = 65; // Margen de seguridad bajo el límite de 70
    private $rateLimitWindow = 60; // 60 segundos
    private $requestCount = 0;
    private $windowStart;

    public function __construct()
    {
        $this->numagencia = config('inmovilla.usuario', '11855_244_ext');
        $this->password = config('inmovilla.password', 'd?%c7Q6ta');
        $this->idioma = config('inmovilla.idioma', 1); // 1 = Español
        $this->windowStart = time();
        
        Log::info('InmovillaApiService inicializado', [
            'usuario' => $this->numagencia,
            'idioma' => $this->idioma
        ]);
    }

    /**
     * Controla el rate limiting para respetar el límite de 70 peticiones/minuto
     */
    private function checkRateLimit()
    {
        $currentTime = time();
        
        // Reiniciar contador si ha pasado la ventana de tiempo
        if ($currentTime - $this->windowStart >= $this->rateLimitWindow) {
            $this->requestCount = 0;
            $this->windowStart = $currentTime;
        }
        
        // Si estamos cerca del límite, esperar
        if ($this->requestCount >= $this->rateLimitRequests) {
            $waitTime = $this->rateLimitWindow - ($currentTime - $this->windowStart) + 1;
            Log::warning('Rate limit alcanzado, esperando', ['wait_seconds' => $waitTime]);
            sleep($waitTime);
            $this->requestCount = 0;
            $this->windowStart = time();
        }
        
        $this->requestCount++;
    }

    /**
     * Obtiene tipos de propiedad desde Inmovilla
     */
    public function getPropertyTypes()
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo tipos de propiedad de Inmovilla');
            
            // Simular llamada a API de Inmovilla
            // En implementación real, aquí iría include('apiinmovilla.php') y las funciones correspondientes
            $response = $this->makeInmovillaRequest('tipos', 1, 100);
            
            Log::info('Tipos de propiedad obtenidos', ['count' => count($response)]);
            return $response;
            
        } catch (Exception $e) {
            Log::error('Error obteniendo tipos de propiedad', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene propiedades con paginación
     */
    public function getProperties($page = 1, $itemsPerPage = 50, $where = '', $order = 'fechaact desc')
    {
        $this->checkRateLimit();
        
        try {
            $startPosition = (($page - 1) * $itemsPerPage) + 1;
            
            Log::info('Obteniendo propiedades de Inmovilla', [
                'page' => $page,
                'items_per_page' => $itemsPerPage,
                'start_position' => $startPosition,
                'where' => $where,
                'order' => $order
            ]);
            
            $response = $this->makeInmovillaRequest('paginacion', $startPosition, $itemsPerPage, $where, $order);
            
            // El primer elemento contiene metadata de paginación
            $metadata = $response[0] ?? [];
            $properties = array_slice($response, 1); // Remover metadata
            
            Log::info('Propiedades obtenidas', [
                'returned_count' => count($properties),
                'total_available' => $metadata['total'] ?? 0
            ]);
            
            return [
                'properties' => $properties,
                'metadata' => $metadata
            ];
            
        } catch (Exception $e) {
            Log::error('Error obteniendo propiedades', [
                'page' => $page,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene propiedades destacadas
     */
    public function getFeaturedProperties()
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo propiedades destacadas de Inmovilla');
            
            $response = $this->makeInmovillaRequest('destacados', 1, 30);
            
            Log::info('Propiedades destacadas obtenidas', ['count' => count($response)]);
            return $response;
            
        } catch (Exception $e) {
            Log::error('Error obteniendo propiedades destacadas', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene una ficha específica de propiedad
     */
    public function getPropertyDetail($codOfer)
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo detalle de propiedad', ['cod_ofer' => $codOfer]);
            
            $response = $this->makeInmovillaRequest('ficha', 1, 1, "cod_ofer=$codOfer");
            
            Log::info('Detalle de propiedad obtenido', ['cod_ofer' => $codOfer]);
            return $response[1] ?? null; // La ficha está en posición 1
            
        } catch (Exception $e) {
            Log::error('Error obteniendo detalle de propiedad', [
                'cod_ofer' => $codOfer,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Lista códigos de propiedades disponibles
     */
    public function getAvailablePropertyCodes()
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo códigos de propiedades disponibles');
            
            $response = $this->makeInmovillaRequest('listar_propiedades_disponibles', 1, 5000);
            
            Log::info('Códigos de propiedades disponibles obtenidos', ['count' => count($response)]);
            return $response;
            
        } catch (Exception $e) {
            Log::error('Error obteniendo códigos de propiedades disponibles', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene propiedades actualizadas desde una fecha específica
     */
    public function getUpdatedPropertiesSince($since)
    {
        $whereClause = "ofertas.fechaact > '$since'";
        return $this->getProperties(1, 50, $whereClause, 'fechaact desc');
    }

    /**
     * Simulación de llamada a API de Inmovilla
     * En implementación real aquí se incluiría apiinmovilla.php y se usarían Procesos() y PedirDatos()
     */
    private function makeInmovillaRequest($tipo, $posInicial, $numElementos, $where = '', $orden = '')
    {
        try {
            // IMPORTANTE: En la implementación real, aquí iría:
            // include_once('apiinmovilla.php');
            // Procesos($tipo, $posInicial, $numElementos, $where, $orden);
            // $result = PedirDatos($this->numagencia, $this->password, $this->idioma);
            
            Log::info('Llamada simulada a API Inmovilla', [
                'tipo' => $tipo,
                'pos_inicial' => $posInicial,
                'num_elementos' => $numElementos,
                'where' => $where,
                'orden' => $orden,
                'usuario' => $this->numagencia
            ]);
            
            // Por ahora devolvemos datos simulados para testing
            return $this->getSimulatedResponse($tipo, $numElementos);
            
        } catch (Exception $e) {
            Log::error('Error en llamada a API Inmovilla', [
                'tipo' => $tipo,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Respuesta simulada para testing (TEMPORAL)
     */
    private function getSimulatedResponse($tipo, $numElementos)
    {
        switch ($tipo) {
            case 'tipos':
                return [
                    ['cod_tipo' => 2799, 'tipo' => 'Apartamento'],
                    ['cod_tipo' => 399, 'tipo' => 'Casa'],
                    ['cod_tipo' => 499, 'tipo' => 'Chalet']
                ];
                
            case 'paginacion':
                $properties = [];
                $properties[0] = [
                    'posicion' => 1,
                    'elementos' => min($numElementos, 3),
                    'total' => 150
                ];
                
                for ($i = 1; $i <= min($numElementos, 3); $i++) {
                    $properties[$i] = [
                        'cod_ofer' => 1000 + $i,
                        'ref' => 'REF-' . (1000 + $i),
                        'keyacci' => 1, // Venta
                        'precioinmo' => 250000 + ($i * 50000),
                        'precioalq' => 1200 + ($i * 200),
                        'nbtipo' => 'Apartamento',
                        'ciudad' => 'Madrid',
                        'zona' => 'Centro',
                        'numagencia' => $this->numagencia,
                        'habitaciones' => 2 + $i,
                        'banyos' => 1 + ($i % 2),
                        'm_cons' => 80 + ($i * 20),
                        'm_uties' => 70 + ($i * 15),
                        'anoconstr' => 2010 + $i,
                        'plantas' => 1 + ($i % 3), // Simula entre 1 y 3 plantas
                        'fechaact' => date('Y-m-d H:i:s')
                    ];
                }
                return $properties;
                
            case 'destacados':
                return [
                    [
                        'cod_ofer' => 2001,
                        'ref' => 'DEST-2001',
                        'keyacci' => 1,
                        'precioinmo' => 350000,
                        'nbtipo' => 'Chalet',
                        'ciudad' => 'Barcelona'
                    ]
                ];
                
            case 'ficha':
                return [
                    0 => ['elementos' => 1],
                    1 => [
                        'cod_ofer' => 1001,
                        'ref' => 'REF-1001',
                        'keyacci' => 1,
                        'precioinmo' => 300000,
                        'titulo' => 'Apartamento en el centro',
                        'descrip' => 'Precioso apartamento completamente reformado'
                    ]
                ];
                
            case 'listar_propiedades_disponibles':
                $codes = [];
                // Simulemos 150 códigos de propiedad para que coincida con el total de 'paginacion'
                for ($i = 1; $i <= 150; $i++) {
                    $codes[] = 1000 + $i;
                }
                return $codes;

            default:
                return [];
        }
    }

    /**
     * Obtiene estadísticas del servicio
     */
    public function getServiceStats()
    {
        return [
            'request_count' => $this->requestCount,
            'window_start' => $this->windowStart,
            'rate_limit' => $this->rateLimitRequests,
            'window_duration' => $this->rateLimitWindow,
            'usuario' => $this->numagencia,
            'idioma' => $this->idioma
        ];
    }
}