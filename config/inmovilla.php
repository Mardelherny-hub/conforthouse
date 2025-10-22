<?php
// config/inmovilla.php

return [
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Tipos de Propiedad Inmovilla → Laravel
    |--------------------------------------------------------------------------
    |
    | Mapeo entre key_tipo de Inmovilla y property_types de Laravel.
    | SOLO 3 TIPOS: Casa (mostrado como Villa), apartamento, Ático
    |
    | CRITERIO DE CLASIFICACIÓN:
    | - APARTAMENTOS: Pisos, planta baja, dúplex, adosados y pareados
    | - VILLAS (Casa en BD): Villa, villa de lujo y chalet  
    | - ÁTICOS: Áticos y ático dúplex
    |
    */
    
    'property_type_mapping' => [
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
        
        // ===== VILLAS/CASAS (se muestra como "Villa" en frontend) =====
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
    ],
    
    /*
    |--------------------------------------------------------------------------
    | Mapeo de Estados de Conservación
    |--------------------------------------------------------------------------
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
    */
    
    'operation_mapping' => [
        1 => 'Venta',           // Venta
        2 => 'Alquiler',        // Alquiler
        3 => 'Venta',           // Traspaso → Venta
        4 => 'Alquiler',        // Leasing → Alquiler
    ],
];