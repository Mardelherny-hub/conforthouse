<?php
// Archivo: public/api/inmovilla-proxy.php
// Proxy para conectar Laravel local con API Inmovilla

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, GET, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization');

// Manejar preflight OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Configuración
$INMOVILLA_USUARIO = '11855_244_ext';
$INMOVILLA_PASSWORD = 'd?%c7Q6ta';
$INMOVILLA_IDIOMA = 1;

// Verificar que tenemos el archivo API
$apiFile = __DIR__ . '/../storage/app/inmovilla/apiinmovilla.php';
if (!file_exists($apiFile)) {
    http_response_code(500);
    echo json_encode(['error' => 'Archivo apiinmovilla.php no encontrado', 'path' => $apiFile]);
    exit();
}

// Simular variables de servidor si no existen
if (!isset($_SERVER['SERVER_NAME'])) {
    $_SERVER['SERVER_NAME'] = 'conforthouse.estudioalcalde.net';
}
if (!isset($_SERVER['REMOTE_ADDR'])) {
    $_SERVER['REMOTE_ADDR'] = '50.6.184.24';
}

try {
    // Obtener parámetros de la petición
    $input = json_decode(file_get_contents('php://input'), true);
    
    if (!$input) {
        throw new Exception('No se recibieron parámetros JSON válidos');
    }
    
    $tipo = $input['tipo'] ?? '';
    $posInicial = (int)($input['pos_inicial'] ?? 1);
    $numElementos = (int)($input['num_elementos'] ?? 50);
    $where = $input['where'] ?? '';
    $orden = $input['orden'] ?? '';
    
    if (empty($tipo)) {
        throw new Exception('Parámetro "tipo" es requerido');
    }
    
    // Log de la petición
    error_log("Inmovilla Proxy - Petición: tipo=$tipo, pos=$posInicial, num=$numElementos");
    
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
    $jsonResult = PedirDatos($INMOVILLA_USUARIO, $INMOVILLA_PASSWORD, $INMOVILLA_IDIOMA, 1);
    
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
        echo json_encode([
            'success' => true,
            'tipo' => $tipo,
            'raw_response' => $jsonResult,
            'is_json' => false
        ]);
    } else {
        // JSON válido
        echo json_encode([
            'success' => true,
            'tipo' => $tipo,
            'data' => $data,
            'is_json' => true,
            'count' => is_array($data) ? count($data) : 0
        ]);
    }
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage(),
        'trace' => $e->getTraceAsString()
    ]);
    
    // Log del error
    error_log("Inmovilla Proxy Error: " . $e->getMessage());
}
?>