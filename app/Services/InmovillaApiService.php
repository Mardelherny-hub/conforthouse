<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
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
    private $apiFilePath;

    public function __construct()
    {
        $this->numagencia = config('inmovilla.usuario', '11855_244_ext');
        $this->password = config('inmovilla.password', 'd?%c7Q6ta');
        $this->idioma = config('inmovilla.idioma', 1); // 1 = Español
        $this->apiFilePath = storage_path('app/inmovilla/apiinmovilla.php');
        $this->windowStart = time();
        
        Log::info('InmovillaApiService inicializado', [
            'usuario' => $this->numagencia,
            'idioma' => $this->idioma,
            'api_file_exists' => file_exists($this->apiFilePath)
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
     * Obtiene provincias disponibles
     */
    public function getProvinces()
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo provincias de Inmovilla');
            
            $response = $this->makeInmovillaRequest('provincias', 1, 100);
            
            Log::info('Provincias obtenidas', ['count' => count($response)]);
            return $response;
            
        } catch (Exception $e) {
            Log::error('Error obteniendo provincias', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene ciudades de una provincia específica
     */
    public function getCities($provinceId = null)
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo ciudades de Inmovilla', ['province_id' => $provinceId]);
            
            $where = $provinceId ? "key_prov=$provinceId" : '';
            $response = $this->makeInmovillaRequest('ciudades', 1, 1000, $where);
            
            Log::info('Ciudades obtenidas', ['count' => count($response)]);
            return $response;
            
        } catch (Exception $e) {
            Log::error('Error obteniendo ciudades', [
                'province_id' => $provinceId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene zonas de una ciudad específica
     */
    public function getZones($cityId)
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo zonas de Inmovilla', ['city_id' => $cityId]);
            
            $response = $this->makeInmovillaRequest('zonas', 1, 500, "key_loca=$cityId");
            
            Log::info('Zonas obtenidas', ['count' => count($response)]);
            return $response;
            
        } catch (Exception $e) {
            Log::error('Error obteniendo zonas', [
                'city_id' => $cityId,
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene estados de conservación
     */
    public function getConservationStates()
    {
        $this->checkRateLimit();
        
        try {
            Log::info('Obteniendo estados de conservación de Inmovilla');
            
            $response = $this->makeInmovillaRequest('tipos_conservacion', 1, 50);
            
            Log::info('Estados de conservación obtenidos', ['count' => count($response)]);
            return $response;
            
        } catch (Exception $e) {
            Log::error('Error obteniendo estados de conservación', [
                'error' => $e->getMessage()
            ]);
            throw $e;
        }
    }

    /**
     * Ejecuta llamada real a la API de Inmovilla
     */
    private function makeInmovillaRequest($tipo, $posInicial, $numElementos, $where = '', $orden = '')
    {
        try {
            // Verificar que existe el archivo API
            if (!file_exists($this->apiFilePath)) {
                throw new Exception("Archivo apiinmovilla.php no encontrado en: {$this->apiFilePath}");
            }

            Log::info('Ejecutando llamada a API Inmovilla', [
                'tipo' => $tipo,
                'pos_inicial' => $posInicial,
                'num_elementos' => $numElementos,
                'where' => $where,
                'orden' => $orden,
                'usuario' => $this->numagencia
            ]);

            // Incluir el archivo de la API de Inmovilla
            include_once($this->apiFilePath);

            // Verificar que las funciones existen
            if (!function_exists('Procesos')) {
                throw new Exception("Función Procesos() no encontrada en apiinmovilla.php");
            }

            if (!function_exists('PedirDatos')) {
                throw new Exception("Función PedirDatos() no encontrada en apiinmovilla.php");
            }

            // Configurar el proceso en la API de Inmovilla
            Procesos($tipo, $posInicial, $numElementos, $where, $orden);

            // Ejecutar la petición
            $result = PedirDatos($this->numagencia, $this->password, $this->idioma);

            // Verificar si hay respuesta
            if ($result === false || $result === null) {
                throw new Exception("La API de Inmovilla no devolvió datos válidos");
            }

            // Verificar si es un array
            if (!is_array($result)) {
                throw new Exception("La respuesta de la API no es un array válido");
            }

            Log::info('Llamada a API Inmovilla exitosa', [
                'tipo' => $tipo,
                'response_count' => count($result),
                'usuario' => $this->numagencia
            ]);

            return $result;

        } catch (Exception $e) {
            Log::error('Error en llamada a API Inmovilla', [
                'tipo' => $tipo,
                'error' => $e->getMessage(),
                'api_file' => $this->apiFilePath,
                'file_exists' => file_exists($this->apiFilePath)
            ]);
            throw $e;
        }
    }

    /**
     * Obtiene estadísticas del servicio
     */
    public function getServiceStats(): array
    {
        return [
            'total_requests' => $this->requestCount,
            'window_start' => date('Y-m-d H:i:s', $this->windowStart),
            'rate_limit_remaining' => max(0, $this->rateLimitRequests - $this->requestCount),
            'api_file_exists' => file_exists($this->apiFilePath),
            'api_file_path' => $this->apiFilePath,
            'usuario' => $this->numagencia,
            'idioma' => $this->idioma,
        ];
    }

    /**
     * Verifica la conectividad con la API
     */
    public function testConnection(): bool
    {
        try {
            // Intentar obtener tipos de propiedad como test básico
            $types = $this->getPropertyTypes();
            return is_array($types) && count($types) > 0;
            
        } catch (Exception $e) {
            Log::error('Test de conexión fallido', [
                'error' => $e->getMessage()
            ]);
            return false;
        }
    }

    /**
     * Limpia la cache de rate limiting (para testing)
     */
    public function resetRateLimit()
    {
        $this->requestCount = 0;
        $this->windowStart = time();
        Log::info('Rate limit reseteado');
    }

    /**
     * Obtiene información detallada de una propiedad incluyendo descripciones multiidioma
     */
    public function getPropertyWithAllLanguages($codOfer): array
    {
        $property = $this->getPropertyDetail($codOfer);
        
        if (!$property) {
            throw new Exception("Propiedad con código {$codOfer} no encontrada");
        }

        // Obtener descripciones en otros idiomas si están disponibles
        $languages = [1 => 'es', 2 => 'en', 3 => 'fr', 4 => 'de'];
        $descriptions = [];
        
        foreach ($languages as $langId => $locale) {
            if ($langId === 1) {
                // El español ya viene en la respuesta principal
                $descriptions[$locale] = [
                    'title' => $property['titulo'] ?? null,
                    'description' => $property['descrip'] ?? null,
                ];
            } else {
                // TODO: Implementar obtención de otros idiomas si la API lo soporta
                // Por ahora solo manejamos español
            }
        }
        
        return [
            'property' => $property,
            'descriptions' => $descriptions
        ];
    }

    /**
     * Valida que el archivo API esté correctamente configurado
     */
    public function validateApiFile(): array
    {
        $validation = [
            'file_exists' => false,
            'functions_exist' => [],
            'is_readable' => false,
            'errors' => []
        ];

        try {
            // Verificar existencia del archivo
            if (file_exists($this->apiFilePath)) {
                $validation['file_exists'] = true;
                $validation['is_readable'] = is_readable($this->apiFilePath);
                
                // Intentar incluir el archivo y verificar funciones
                include_once($this->apiFilePath);
                
                $requiredFunctions = ['Procesos', 'PedirDatos'];
                foreach ($requiredFunctions as $func) {
                    $validation['functions_exist'][$func] = function_exists($func);
                    if (!function_exists($func)) {
                        $validation['errors'][] = "Función requerida {$func}() no encontrada";
                    }
                }
            } else {
                $validation['errors'][] = "Archivo apiinmovilla.php no encontrado en {$this->apiFilePath}";
            }

        } catch (Exception $e) {
            $validation['errors'][] = "Error validando archivo API: " . $e->getMessage();
        }

        return $validation;
    }
}