<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Log;
use Exception;

class InmovillaProxyController extends Controller
{
    private $numagencia = '11855_244_ext';
    private $password = 'd?%c7Q6ta';
    private $idioma = 1;

    public function proxy(Request $request): JsonResponse
    {
        try {
            // Validar parámetros
            $tipo = $request->input('tipo');
            $posInicial = (int)$request->input('pos_inicial', 1);
            $numElementos = (int)$request->input('num_elementos', 50);
            $where = $request->input('where', '');
            $orden = $request->input('orden', '');

            if (empty($tipo)) {
                throw new Exception('Parámetro "tipo" es requerido');
            }

            // Log de la petición
            Log::info('Inmovilla Proxy - Petición', [
                'tipo' => $tipo,
                'pos_inicial' => $posInicial,
                'num_elementos' => $numElementos,
                'where' => $where,
                'orden' => $orden
            ]);

            // Verificar archivo API
            $apiFile = storage_path('app/inmovilla/apiinmovilla.php');
            if (!file_exists($apiFile)) {
                throw new Exception('Archivo apiinmovilla.php no encontrado en: ' . $apiFile);
            }

            // Incluir archivo API
            include_once($apiFile);

            // Verificar funciones
            if (!function_exists('Procesos') || !function_exists('PedirDatos')) {
                throw new Exception('Funciones Procesos() o PedirDatos() no encontradas');
            }

            // Limpiar peticiones anteriores
            $GLOBALS['arrpeticiones'] = array();

            // Configurar petición
            Procesos($tipo, $posInicial, $numElementos, $where, $orden);

            // Ejecutar petición en modo JSON
            $jsonResult = PedirDatos($this->numagencia, $this->password, $this->idioma, 1);

            // Verificar respuesta
            if (empty($jsonResult)) {
                throw new Exception('API de Inmovilla no devolvió datos');
            }

            // Verificar si hay error en la respuesta
            if (strpos($jsonResult, 'die(') !== false || strpos($jsonResult, 'IP NO VALIDADA') !== false) {
                throw new Exception('Error de API: ' . substr($jsonResult, 0, 200));
            }

            // Intentar decodificar JSON
            $data = json_decode($jsonResult, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                // Si no es JSON válido, devolver como texto raw
                return response()->json([
                    'success' => true,
                    'tipo' => $tipo,
                    'raw_response' => $jsonResult,
                    'is_json' => false
                ]);
            } else {
                // JSON válido
                return response()->json([
                    'success' => true,
                    'tipo' => $tipo,
                    'data' => $data,
                    'is_json' => true,
                    'count' => is_array($data) ? count($data) : 0
                ]);
            }

        } catch (Exception $e) {
            Log::error('Inmovilla Proxy Error', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}