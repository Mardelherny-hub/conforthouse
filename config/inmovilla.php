<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Tipos de Propiedad Inmovilla → Laravel
    |--------------------------------------------------------------------------
    |
    | Mapeo entre key_tipo de Inmovilla y property_types de Laravel.
    | SOLO 3 TIPOS: Casa (mostrado como Villa), apartamento, Ático
    |
    */
    
    'property_type_mapping' => [
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
        
        // VILLAS/CASAS → Casa (se muestra como "Villa" en español en frontend)
        399  => 'Casa',           // Casa
        499  => 'Casa',           // Chalet
        199  => 'Casa',           // Adosado
        299  => 'Casa',           // Bungalow
        999  => 'Casa',           // Pareado
        4999 => 'Casa',           // Villa
        599  => 'Casa',           // Cortijo
        899  => 'Casa',           // Masía
        
        // COMERCIALES Y TERRENOS → Casa
        1299 => 'Casa',           // Local comercial
        1399 => 'Casa',           // Oficina
        2399 => 'Casa',           // Garaje
        2599 => 'Casa',           // Parking
        2699 => 'Casa',           // Trastero
        3699 => 'Casa',           // Finca rústica
        3899 => 'Casa',           // Solar
        4199 => 'Casa',           // Terreno urbano
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Estados de Conservación
    |--------------------------------------------------------------------------
    |
    | Mapeo entre conservacion de Inmovilla y statuses de Laravel.
    | SOLO 2 ESTADOS: Disponible, Reservado
    |
    */
    
    'conservation_mapping' => [
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
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Operaciones
    |--------------------------------------------------------------------------
    |
    | Mapeo entre keyacci de Inmovilla y operations de Laravel.
    | SOLO 3 OPERACIONES: Venta, Alquiler, Viviendas de Lujo
    |
    */
    
    'operation_mapping' => [
        1 => 'Venta',
        2 => 'Alquiler',
        3 => 'Venta',      // Traspaso → Venta
        4 => 'Alquiler',   // Leasing → Alquiler
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
        'max_price' => 50000000,
        'min_price' => 1000,
        'max_area' => 10000,
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración API Inmovilla
    |--------------------------------------------------------------------------
    */

    'usuario' => env('INMOVILLA_USUARIO', '11855_244_ext'),
    'password' => env('INMOVILLA_PASSWORD', 'd?%c7Q6ta'),
    'idioma' => env('INMOVILLA_IDIOMA', 1),
    'api_file_path' => env('INMOVILLA_API_FILE', storage_path('app/inmovilla/apiinmovilla.php')),
    
    /*
    |--------------------------------------------------------------------------
    | Rate Limiting
    |--------------------------------------------------------------------------
    */
    
    'rate_limit' => [
        'max_requests' => env('INMOVILLA_MAX_REQUESTS', 65),
        'window_seconds' => env('INMOVILLA_WINDOW_SECONDS', 60),
        'retry_after_block' => env('INMOVILLA_RETRY_AFTER_BLOCK', 600),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Sincronización
    |--------------------------------------------------------------------------
    */
    
    'sync' => [
        'batch_size' => env('INMOVILLA_BATCH_SIZE', 50),
        'max_featured' => env('INMOVILLA_MAX_FEATURED', 30),
        'max_available_codes' => env('INMOVILLA_MAX_AVAILABLE_CODES', 5000),
        'sync_interval_hours' => env('INMOVILLA_SYNC_INTERVAL_HOURS', 24),
        'delta_sync_minutes' => env('INMOVILLA_DELTA_SYNC_MINUTES', 60),
        'auto_translate' => env('INMOVILLA_AUTO_TRANSLATE', true),
        'translation_languages' => ['en', 'fr', 'de'],
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Logging
    |--------------------------------------------------------------------------
    */
    
    'logging' => [
        'enabled' => env('INMOVILLA_LOGGING_ENABLED', true),
        'level' => env('INMOVILLA_LOG_LEVEL', 'info'),
        'log_api_responses' => env('INMOVILLA_LOG_API_RESPONSES', false),
        'log_failed_requests' => env('INMOVILLA_LOG_FAILED_REQUESTS', true),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | URLs y Endpoints
    |--------------------------------------------------------------------------
    */
    
    'urls' => [
        'base_url' => env('INMOVILLA_BASE_URL', null),
        'api_version' => env('INMOVILLA_API_VERSION', 'v1'),
        'timeout' => env('INMOVILLA_REQUEST_TIMEOUT', 30),
    ],
];