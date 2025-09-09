<?php


return [
    /*
    |--------------------------------------------------------------------------
    | Configuración API Inmovilla
    |--------------------------------------------------------------------------
    |
    | Configuración para la integración con la API de Inmovilla.
    | Credenciales y parámetros de conexión.
    |
    */

    // Credenciales de acceso
    'usuario' => env('INMOVILLA_USUARIO', '11855_244_ext'),
    'password' => env('INMOVILLA_PASSWORD', 'd?%c7Q6ta'),
    
    // Configuración de idioma
    'idioma' => env('INMOVILLA_IDIOMA', 1), // 1 = Español
    
    // Ruta del archivo API
    'api_file_path' => env('INMOVILLA_API_FILE', storage_path('app/inmovilla/apiinmovilla.php')),
    
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    |
    | Configuración para el control de peticiones por minuto.
    | API Inmovilla tiene límite de 70 peticiones/minuto con bloqueo de 10 min.
    |
    */
    
    'rate_limit' => [
        'max_requests' => env('INMOVILLA_MAX_REQUESTS', 65), // Margen de seguridad
        'window_seconds' => env('INMOVILLA_WINDOW_SECONDS', 60),
        'retry_after_block' => env('INMOVILLA_RETRY_AFTER_BLOCK', 600), // 10 minutos
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Sincronización
    |--------------------------------------------------------------------------
    |
    | Parámetros para la sincronización de propiedades.
    |
    */
    
    'sync' => [
        'batch_size' => env('INMOVILLA_BATCH_SIZE', 50), // Propiedades por lote
        'max_featured' => env('INMOVILLA_MAX_FEATURED', 30), // Destacadas máximo
        'max_available_codes' => env('INMOVILLA_MAX_AVAILABLE_CODES', 5000),
        'sync_interval_hours' => env('INMOVILLA_SYNC_INTERVAL_HOURS', 24), // Sincronización completa cada 24h
        'delta_sync_minutes' => env('INMOVILLA_DELTA_SYNC_MINUTES', 60), // Sincronización delta cada hora
        'auto_translate' => env('INMOVILLA_AUTO_TRANSLATE', true), // Traducir automáticamente
        'translation_languages' => ['en', 'fr', 'de'], // Idiomas a traducir
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Validación y Testing
    |--------------------------------------------------------------------------
    |
    | Configuración para pruebas y validaciones de la API.
    |
    */
    
    'testing' => [
        'enable_mock_data' => env('INMOVILLA_ENABLE_MOCK', false), // Solo para desarrollo
        'mock_property_count' => env('INMOVILLA_MOCK_COUNT', 10),
        'connection_timeout' => env('INMOVILLA_TIMEOUT', 30), // segundos
        'retry_attempts' => env('INMOVILLA_RETRY_ATTEMPTS', 3),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Operaciones
    |--------------------------------------------------------------------------
    |
    | Mapeo entre keyacci de Inmovilla y operations de Laravel.
    |
    */
    
    'operation_mapping' => [
        1 => 'Venta',        // keyacci 1 = Venta
        2 => 'Alquiler',     // keyacci 2 = Alquiler  
        3 => 'Traspaso',     // keyacci 3 = Traspaso
        4 => 'Leasing',      // keyacci 4 = Leasing
        9 => 'Alquiler',     // keyacci 9 = Alquiler Vacacional → Alquiler
        15 => 'Alquiler',    // keyacci 15 = Alquiler Opción Compra → Alquiler
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Tipos de Propiedad
    |--------------------------------------------------------------------------
    |
    | Mapeo entre key_tipo de Inmovilla y property_types de Laravel.
    |
    */
    
    'property_type_mapping' => [
        // Apartamentos y pisos
        2799 => 'Departamento',    // Apartamento
        2899 => 'Ático',           // Ático
        2999 => 'Departamento',    // Duplex → Departamento
        3099 => 'Departamento',    // Estudio → Departamento
        3199 => 'Departamento',    // Habitación → Departamento
        3299 => 'Departamento',    // Loft → Departamento
        3399 => 'Departamento',    // Piso → Departamento
        3499 => 'Departamento',    // Planta baja → Departamento
        3599 => 'Departamento',    // Triplex → Departamento
        
        // Casas
        399  => 'Casa',            // Casa
        499  => 'Casa',            // Chalet → Casa
        199  => 'Adosado',         // Adosado
        299  => 'Casa',            // Bungalow → Casa
        999  => 'Casa',            // Pareado → Casa
        4999 => 'Casa',            // Villa → Casa
        599  => 'Casa',            // Cortijo → Casa
        899  => 'Casa',            // Masía → Casa
        
        // Comerciales y otros
        1299 => 'Casa',            // Local comercial → Casa
        1399 => 'Casa',            // Oficina → Casa
        2399 => 'Casa',            // Garaje → Casa
        2599 => 'Casa',            // Parking → Casa
        2699 => 'Casa',            // Trastero → Casa
        3699 => 'Casa',            // Finca rústica → Casa
        3899 => 'Casa',            // Solar → Casa
        4199 => 'Casa',            // Terreno urbano → Casa
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Estados de Conservación
    |--------------------------------------------------------------------------
    |
    | Mapeo entre conservacion de Inmovilla y statuses de Laravel.
    |
    */
    
    'conservation_mapping' => [
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
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Campos de Descripción y Título
    |--------------------------------------------------------------------------
    |
    | Mapeo para campos que requieren descripción adicional desde array ficha.
    |
    */
    
    'description_fields' => [
        'titulo' => 'title',
        'descrip' => 'description',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Idiomas Soportados
    |--------------------------------------------------------------------------
    |
    | Mapeo entre IDs de idioma de Inmovilla y locales Laravel.
    |
    */
    
    'language_mapping' => [
        1 => 'es',    // Español
        2 => 'en',    // Inglés  
        3 => 'fr',    // Francés
        4 => 'de',    // Alemán
        5 => 'it',    // Italiano
        6 => 'pt',    // Portugués
        7 => 'ru',    // Ruso
        8 => 'nl',    // Holandés
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Validación de Datos
    |--------------------------------------------------------------------------
    |
    | Reglas de validación para datos de Inmovilla antes de guardar.
    |
    */
    
    'validation' => [
        'required_fields' => [
            'cod_ofer',
            'ref',
            'keyacci',
        ],
        'numeric_fields' => [
            'cod_ofer',
            'keyacci',
            'key_tipo',
            'precioinmo',
            'precioalq',
            'm_cons',
            'habitaciones',
            'banyos',
        ],
        'max_price' => 50000000, // 50 millones máximo
        'min_price' => 1000,     // 1000 euros mínimo
        'max_area' => 10000,     // 10,000 m² máximo
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Logging
    |--------------------------------------------------------------------------
    |
    | Configuración específica para logs de Inmovilla.
    |
    */
    
    'logging' => [
        'enabled' => env('INMOVILLA_LOGGING_ENABLED', true),
        'level' => env('INMOVILLA_LOG_LEVEL', 'info'), // debug, info, warning, error
        'log_api_responses' => env('INMOVILLA_LOG_API_RESPONSES', false),
        'log_failed_requests' => env('INMOVILLA_LOG_FAILED_REQUESTS', true),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | URLs y Endpoints
    |--------------------------------------------------------------------------
    |
    | Configuración de URLs si fuera necesario para futuras extensiones.
    |
    */
    
    'urls' => [
        'base_url' => env('INMOVILLA_BASE_URL', null), // Por si cambian a REST API
        'api_version' => env('INMOVILLA_API_VERSION', 'v1'),
        'timeout' => env('INMOVILLA_REQUEST_TIMEOUT', 30),
    ],
];