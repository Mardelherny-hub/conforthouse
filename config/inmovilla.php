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
    | Mapeo de Campos Principales
    |--------------------------------------------------------------------------
    |
    | Mapeo exacto entre campos de Inmovilla y campos del modelo Property.
    | Coincide con la migración 2025_XX_XX_add_inmovilla_fields_to_properties
    |
    */
    
    'field_mapping' => [
        // === IDENTIFICACIÓN INMOVILLA ===
        'cod_ofer' => 'cod_ofer',
        'numagencia' => 'inmovilla_numagencia', 
        'ref' => 'inmovilla_ref',
        'fechaact' => 'inmovilla_fechaact',
        
        // === TIPO Y OPERACIÓN ===
        'keyacci' => 'inmovilla_keyacci',
        'key_tipo' => 'inmovilla_key_tipo',
        
        // === PRECIOS ===
        'precioinmo' => 'price_sale',
        'precioalq' => 'price_rent',
        'outlet' => 'price_outlet',
        'tipomensual' => 'rent_period',
        
        // === MEDIDAS ===
        'm_parcela' => 'plot_area_m2',
        'm_uties' => 'useful_area_m2',
        'm_cons' => 'built_area_m2',
        'm_terraza' => 'terrace_area_m2',
        
        // === HABITACIONES Y BAÑOS ===
        'habdobles' => 'double_rooms',
        'habitaciones' => 'single_rooms',
        'total_hab' => 'total_rooms',
        'banyos' => 'bathrooms', // Campo existente
        'aseos' => 'toilets',
        
        // === CARACTERÍSTICAS BÁSICAS ===
        'ascensor' => 'has_elevator',
        'aire_con' => 'has_air_conditioning',
        'calefaccion' => 'has_heating',
        'parking' => 'parking_type',
        'piscina_com' => 'has_community_pool',
        'piscina_prop' => 'has_private_pool',
        'diafano' => 'is_diaphanous',
        'todoext' => 'is_all_exterior',
        
        // === CERTIFICACIÓN ENERGÉTICA ===
        'energialetra' => 'energy_certificate_letter',
        'energiavalor' => 'energy_consumption_value',
        'emisionesletra' => 'emissions_certificate_letter',
        'emisionesvalor' => 'emissions_value',
        
        // === CAMPOS ENUM INMOVILLA ===
        'conservacion' => 'inmovilla_conservacion',
        'cocina_inde' => 'inmovilla_cocina_inde',
        'keyori' => 'inmovilla_keyori',
        'keyvista' => 'inmovilla_keyvista',
        'keyagua' => 'inmovilla_keyagua',
        'keycalefa' => 'inmovilla_keycalefa',
        'keycarpin' => 'inmovilla_keycarpin',
        'keycarpinext' => 'inmovilla_keycarpinext',
        'keysuelo' => 'inmovilla_keysuelo',
        'keytecho' => 'inmovilla_keytecho',
        'keyfachada' => 'inmovilla_keyfachada',
        'keyelectricidad' => 'inmovilla_keyelectricidad',
        'x_entorno' => 'inmovilla_x_entorno',
        
        // === OTROS CAMPOS INMOVILLA ===
        'tipovpo' => 'inmovilla_tipovpo',
        'electro' => 'inmovilla_electro',
        'destacado' => 'inmovilla_destacado',
        'estadoficha' => 'inmovilla_estadoficha',
        'eninternet' => 'inmovilla_eninternet',
        'tgascom' => 'inmovilla_tgascom',
        
        // === MULTIMEDIA ===
        'numfotos' => 'photo_count',
        'foto' => 'main_photo_url',
        'tourvirtual' => 'has_virtual_tour',
        'fotos360' => 'has_360_photos',
        'video' => 'has_video_content',
        'antesydespues' => 'has_before_after_photos',
        'fotoletra' => 'photo_letter_id',
        
        // === INFORMACIÓN DE AGENCIA ===
        'agencia' => 'agency_name',
        'web' => 'agency_website',
        'emailagencia' => 'agency_email',
        'telefono' => 'agency_phone',
        
        // === UBICACIÓN ===
        'ciudad' => 'inmovilla_ciudad',
        'zona' => 'inmovilla_zona',
        'key_loca' => 'inmovilla_key_loca',
        'key_zona' => 'inmovilla_key_zona',
        'keypromo' => 'inmovilla_keypromo',
        
        // === CAMPOS EXISTENTES MANTENIDOS ===
        'distmar' => 'distance_to_sea',
        'plantas' => 'floors',
        'planta' => 'floor',
        'anio_const' => 'year_built',
        'garajes' => 'parking_spaces',
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
        1 => 'venta',       // For sale
        2 => 'alquiler',    // Rent
        3 => 'traspaso',    // Transfer
        4 => 'venta_alquiler', // Sell or Rent
        9 => 'alquiler_vacacional', // Vacation Rental
        15 => 'alquiler_opcion_compra', // Rent to Own
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
        2799 => 'apartamento',
        2899 => 'atico',
        2999 => 'duplex',
        3099 => 'estudio',
        3199 => 'habitacion',
        3299 => 'loft',
        3399 => 'piso',
        3499 => 'planta_baja',
        3599 => 'triplex',
        399 => 'casa',
        499 => 'chalet',
        199 => 'adosado',
        299 => 'bungalow',
        999 => 'pareado',
        4999 => 'villa',
        599 => 'cortijo',
        899 => 'masia',
        1299 => 'local_comercial',
        1399 => 'oficina',
        2399 => 'garaje',
        2599 => 'parking',
        2699 => 'trastero',
        3699 => 'finca_rustica',
        3899 => 'solar',
        4199 => 'terreno_urbano',
        // Agregar más según necesidades
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Estados de Conservación
    |--------------------------------------------------------------------------
    */
    
    'conservation_mapping' => [
        5 => 'para_reformar',
        10 => 'de_origen',
        15 => 'reformar_parcialmente',
        20 => 'entrar_vivir',
        30 => 'buen_estado',
        40 => 'semireformado',
        50 => 'reformado',
        60 => 'seminuevo',
        70 => 'nuevo',
        80 => 'obra_nueva',
        90 => 'en_construccion',
        100 => 'en_proyecto',
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
    | Validación de Datos
    |--------------------------------------------------------------------------
    |
    | Reglas de validación para datos de Inmovilla antes de guardar.
    |
    */
    
    'validation_rules' => [
        'cod_ofer' => 'required|integer',
        'ref' => 'required|string|max:255',
        'inmovilla_keyacci' => 'required|integer|in:1,2,3,4,9,15',
        'price_sale' => 'nullable|numeric|min:0',
        'price_rent' => 'nullable|numeric|min:0',
        'built_area_m2' => 'nullable|integer|min:1',
        'total_rooms' => 'nullable|integer|min:0',
        'bathrooms' => 'nullable|integer|min:0',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Estados de Sincronización
    |--------------------------------------------------------------------------
    */
    
    'sync_status' => [
        'pending' => 'pending',
        'in_progress' => 'in_progress', 
        'completed' => 'completed',
        'failed' => 'failed',
        'partial' => 'partial',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Logging
    |--------------------------------------------------------------------------
    */
    
    'logging' => [
        'channel' => env('INMOVILLA_LOG_CHANNEL', 'daily'),
        'level' => env('INMOVILLA_LOG_LEVEL', 'info'),
        'log_requests' => env('INMOVILLA_LOG_REQUESTS', true),
        'log_responses' => env('INMOVILLA_LOG_RESPONSES', false), // Solo en desarrollo
        'log_sync_details' => env('INMOVILLA_LOG_SYNC_DETAILS', true),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | URLs y Rutas de la API
    |--------------------------------------------------------------------------
    */
    
    'urls' => [
        'api_file' => env('INMOVILLA_API_FILE', storage_path('app/inmovilla/apiinmovilla.php')),
        'photos_base' => 'https://fotos15.apinmo.com/',
        'tour_virtual' => 'http://ap.apinmo.com/fotosvr/tour.php?cod=',
        'panoramic_viewer' => 'http://ap.apinmo.com/fotosvr/?codigo=',
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Caché
    |--------------------------------------------------------------------------
    */
    
    'cache' => [
        'enabled' => env('INMOVILLA_CACHE_ENABLED', true),
        'ttl_types' => env('INMOVILLA_CACHE_TTL_TYPES', 86400), // 24 horas para tipos
        'ttl_properties' => env('INMOVILLA_CACHE_TTL_PROPERTIES', 3600), // 1 hora para propiedades
        'ttl_featured' => env('INMOVILLA_CACHE_TTL_FEATURED', 1800), // 30 minutos para destacadas
        'prefix' => env('INMOVILLA_CACHE_PREFIX', 'inmovilla_'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Imágenes
    |--------------------------------------------------------------------------
    */
    
    'images' => [
        'download_enabled' => env('INMOVILLA_DOWNLOAD_IMAGES', true),
        'storage_path' => env('INMOVILLA_IMAGES_PATH', 'public/properties/inmovilla'),
        'max_size_mb' => env('INMOVILLA_MAX_IMAGE_SIZE', 5),
        'allowed_extensions' => ['jpg', 'jpeg', 'png', 'gif'],
        'create_thumbnails' => env('INMOVILLA_CREATE_THUMBNAILS', true),
        'thumbnail_size' => env('INMOVILLA_THUMBNAIL_SIZE', '300x200'),
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Configuración de Traducciones Automáticas
    |--------------------------------------------------------------------------
    */
    
    'translations' => [
        'enabled' => env('INMOVILLA_TRANSLATIONS_ENABLED', true),
        'source_language' => 'es',
        'target_languages' => ['en', 'fr', 'de'],
        'service' => env('INMOVILLA_TRANSLATION_SERVICE', 'google'), // google, libre, deepl
        'batch_size' => env('INMOVILLA_TRANSLATION_BATCH_SIZE', 10),
        
        // Campos que serán traducidos automáticamente
        'translatable_fields' => [
            'title',
            'description', 
            'meta_description',
            'condition',
            'orientation',
            'exterior_type',
            'kitchen_type',
            'heating_type',
            'interior_carpentry',
            'exterior_carpentry',
            'flooring_type',
            'views',
            'regime',
        ],
        
        // Campos ENUM que serán mapeados usando PropertyTranslation
        'enum_translatable_fields' => [
            'water_heating_type',
            'heating_system_type',
            'interior_carpentry_material',
            'exterior_carpentry_material',
            'floor_material',
            'ceiling_type',
            'facade_type',
            'electrical_system',
            'conservation_state',
            'kitchen_style',
            'appliances_included',
            'environment_features',
        ],
    ],
];