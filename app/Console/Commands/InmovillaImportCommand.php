<?php

namespace App\Console\Commands;

use App\Models\Property;
use App\Models\PropertyDescription;
use App\Models\PropertyImage;
use App\Models\PropertyVideo;
use App\Models\Address;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InmovillaImportCommand extends Command
{
    protected $signature = 'inmovilla:import {xml_file_path}';
    protected $description = 'Importa propiedades desde XML de Inmovilla - DIRECTO Y SIMPLE';

    public function handle()
    {
        $xmlPath = $this->argument('xml_file_path');
        
        if (!file_exists($xmlPath)) {
            $this->error("❌ Archivo XML no encontrado: {$xmlPath}");
            return Command::FAILURE;
        }

        $this->info("🚀 Iniciando importación desde: {$xmlPath}");
        
        try {
            // Cargar XML con encoding UTF-8
            $xmlContent = file_get_contents($xmlPath);
            $xml = simplexml_load_string($xmlContent);
            if (!$xml) {
                $this->error("❌ Error al cargar XML");
                return Command::FAILURE;
            }

            $totalProperties = count($xml->propiedad);
            $this->info("📊 Total propiedades encontradas: {$totalProperties}");

            $imported = 0;
            $errors = 0;

            foreach ($xml->propiedad as $xmlProperty) {
                try {
                    $this->importProperty($xmlProperty);
                    $imported++;
                    
                    if ($imported % 10 == 0) {
                        $this->info("✅ Importadas: {$imported}/{$totalProperties}");
                    }
                } catch (\Exception $e) {
                    $errors++;
                    $id = (string)$xmlProperty->id;
                    $this->error("❌ Error en propiedad ID {$id}: " . $e->getMessage());
                    Log::error("Error importando propiedad {$id}", ['error' => $e->getMessage()]);
                }
            }

            $this->info("🎉 Importación completada:");
            $this->info("   ✅ Importadas: {$imported}");
            $this->info("   ❌ Errores: {$errors}");

            return Command::SUCCESS;

        } catch (\Exception $e) {
            $this->error("❌ Error general: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    private function importProperty($xmlProperty)
    {
        DB::transaction(function () use ($xmlProperty) {

            // === DEBUG TEMPORAL - AGREGAR ANTES DEL updateOrCreate ===
            $terraza = (string)$xmlProperty->terraza;
            $jardin = (string)$xmlProperty->jardin; 
            $piscina_prop = (string)$xmlProperty->piscina_prop;
            $piscina_com = (string)$xmlProperty->piscina_com;

            Log::info("DEBUG CARACTERÍSTICAS", [
                'id' => (string)$xmlProperty->id,
                'ref' => (string)$xmlProperty->ref,
                'terraza_xml' => $terraza,
                'jardin_xml' => $jardin,
                'piscina_prop_xml' => $piscina_prop,
                'piscina_com_xml' => $piscina_com,
                'terraza_bool' => (bool)$xmlProperty->terraza,
                'jardin_bool' => (bool)$xmlProperty->jardin,
                'piscina_prop_bool' => (bool)$xmlProperty->piscina_prop,
                'piscina_com_bool' => (bool)$xmlProperty->piscina_com,
            ]);
            
            // MAPEO DIRECTO XML → BD EXISTENTE
            $property = Property::updateOrCreate(
                ['cod_ofer' => (int)$xmlProperty->id], // Clave única Inmovilla
                [
                    // === IDENTIFICACIÓN ===
                    'reference' => (string)$xmlProperty->ref,
                    'inmovilla_ref' => (string)$xmlProperty->ref,
                    'numagencia' => (string)$xmlProperty->numagencia,
                    'fechaact' => $this->parseDate((string)$xmlProperty->fechaact),
                    
                    // === OPERACIÓN Y TIPO ===
                    'operation_id' => $this->mapOperation((string)$xmlProperty->accion),
                    'property_type_id' => $this->mapPropertyType((string)$xmlProperty->tipo_ofer),
                    'status_id' => $this->mapStatus((int)$xmlProperty->estadoficha),
                    
                    // === PRECIOS ===
                    'price' => (float)$xmlProperty->precioinmo ?: (float)$xmlProperty->precioalq,
                    'precioinmo' => (float)$xmlProperty->precioinmo,
                    'precioalq' => (float)$xmlProperty->precioalq,
                    'outlet' => (float)$xmlProperty->outlet,
                    'tipomensual' => (string)$xmlProperty->tipomensual,
                    
                    // === MEDIDAS ===
                    'built_area' => (int)$xmlProperty->m_cons,
                    'm_parcela' => (int)$xmlProperty->m_parcela,
                    'm_uties' => (int)$xmlProperty->m_uties,
                    'm_terraza' => (int)$xmlProperty->m_terraza,
                    
                    // === HABITACIONES ===
                    'rooms' => (int)$xmlProperty->habdobles + (int)$xmlProperty->habitaciones,
                    'habitaciones_simples' => (int)$xmlProperty->habitaciones,
                    'total_hab' => (int)$xmlProperty->habdobles + (int)$xmlProperty->habitaciones,
                    'bathrooms' => (int)$xmlProperty->banyos,
                    'habdobles' => (int)$xmlProperty->habdobles,
                    'aseos' => (int)$xmlProperty->aseos,
                    
                    // === CARACTERÍSTICAS BÁSICAS ===
                    'ascensor' => ((string)$xmlProperty->ascensor === '1'),
                    'aire_con' => ((string)$xmlProperty->aire_con === '1'),
                    'calefaccion' => ((string)$xmlProperty->calefaccion === '1'),
                    'parking' => (int)$xmlProperty->parking,
                    'piscina_com' => ((string)$xmlProperty->piscina_com === '1'),
                    'piscina_prop' => ((string)$xmlProperty->piscina_prop === '1'),
                    'diafano' => ((string)$xmlProperty->diafano === '1'),
                    'todoext' => (int)$xmlProperty->todoext,
                    'google_map' => $this->buildGoogleMapUrl($xmlProperty),

                    // === CARACTERÍSTICAS ADICIONALES BOOLEANAS ===
                    'balcon' => ((string)$xmlProperty->balcon === '1'),
                    'bar' => ((string)$xmlProperty->bar === '1'),
                    'jardin' => ((string)$xmlProperty->jardin === '1'),
                    'barbacoa' => ((string)$xmlProperty->barbacoa === '1'),
                    'cajafuerte' => ((string)$xmlProperty->cajafuerte === '1'),
                    'calefacentral' => ((string)$xmlProperty->calefacentral === '1'),
                    'chimenea' => ((string)$xmlProperty->chimenea === '1'),
                    'depoagua' => ((string)$xmlProperty->depoagua === '1'),
                    'descalcificador' => ((string)$xmlProperty->descalcificador === '1'),
                    'despensa' => ((string)$xmlProperty->despensa === '1'),
                    'esquina' => ((string)$xmlProperty->esquina === '1'),
                    'galeria' => ((string)$xmlProperty->galeria === '1'),
                    'garajedoble' => ((string)$xmlProperty->garajedoble === '1'),
                    'gasciudad' => ((string)$xmlProperty->gasciudad === '1'),
                    'gimnasio' => ((string)$xmlProperty->gimnasio === '1'),
                    'habjuegos' => ((string)$xmlProperty->habjuegos === '1'),
                    'hidromasaje' => ((string)$xmlProperty->hidromasaje === '1'),
                    'jacuzzi' => ((string)$xmlProperty->jacuzzi === '1'),
                    'lavanderia' => ((string)$xmlProperty->lavanderia === '1'),
                    'linea_tlf' => ((string)$xmlProperty->linea_tlf === '1'),
                    'luminoso' => ((string)$xmlProperty->luminoso === '1'),
                    'luz' => ((string)$xmlProperty->luz === '1'),
                    'muebles' => ((string)$xmlProperty->muebles === '1'),
                    'ojobuey' => ((string)$xmlProperty->ojobuey === '1'),
                    'patio' => ((string)$xmlProperty->patio === '1'),
                    'preinstaacc' => ((string)$xmlProperty->preinstaacc === '1'),
                    'primera_line' => ((string)$xmlProperty->primera_line === '1'),
                    'puerta_blin' => ((string)$xmlProperty->puerta_blin === '1'),
                    'satelite' => ((string)$xmlProperty->satelite === '1'),
                    'sauna' => ((string)$xmlProperty->sauna === '1'),
                    'solarium' => ((string)$xmlProperty->solarium === '1'),
                    'sotano' => ((string)$xmlProperty->sotano === '1'),
                    'mirador' => ((string)$xmlProperty->mirador === '1'),
                    'apartseparado' => ((string)$xmlProperty->apartseparado === '1'),
                    'bombafriocalor' => ((string)$xmlProperty->bombafriocalor === '1'),
                    'buhardilla' => ((string)$xmlProperty->buhardilla === '1'),
                    'pergola' => ((string)$xmlProperty->pergola === '1'),
                    'tv' => ((string)$xmlProperty->tv === '1'),
                    'terraza' => ((string)$xmlProperty->terraza === '1'),
                    'terrazaacris' => ((string)$xmlProperty->terrazaacris === '1'),
                    'trastero' => ((string)$xmlProperty->trastero === '1'),
                    'urbanizacion' => ((string)$xmlProperty->urbanizacion === '1'),
                    'vestuarios' => ((string)$xmlProperty->vestuarios === '1'),
                    'vistasalmar' => ((string)$xmlProperty->vistasalmar === '1'),

                    // === CAMPOS NUMÉRICOS ADICIONALES ===
                    'plaza_gara' => (int)$xmlProperty->plaza_gara,
                    'nplazasparking' => (int)$xmlProperty->nplazasparking,
                    'ibi' => (float)$xmlProperty->ibi,
                    
                    // === CONSTRUCCIÓN ===
                    'year_built' => (int)$xmlProperty->antiguedad,
                    'anoconstr' => (int)$xmlProperty->antiguedad,
                    'garajes' => (int)$xmlProperty->plaza_gara,
                    'floors' => (int)$xmlProperty->numplanta,
                    'floor' => (int)$xmlProperty->planta,
                    
                    // === CERTIFICACIÓN ENERGÉTICA ===
                    'energialetra' => (string)$xmlProperty->energialetra,
                    'energiavalor' => (float)$xmlProperty->energiavalor,
                    'emisionesletra' => (string)$xmlProperty->emisionesletra,
                    'emisionesvalor' => (float)$xmlProperty->emisionesvalor,
                    
                    // === UBICACIÓN INMOVILLA ===
                    'ciudad_inmovilla' => (string)$xmlProperty->ciudad,
                    'zona_inmovilla' => (string)$xmlProperty->zona,
                    'key_loca' => (int)$xmlProperty->key_loca,
                    'key_tipo' => (int)$xmlProperty->key_tipo,
                    
                    // === CAMPOS ENUM INMOVILLA ===
                    // === CAMPOS COMO TEXTO DIRECTO ===
                    'conservacion' => $this->mapConservacionToCode((string)$xmlProperty->conservacion),
                    'cocina_inde' => (int)$xmlProperty->cocina_inde,
                    'keyori' => $this->parseIntOrNull($xmlProperty->orientacion),
                    'keyvista' => (int)$xmlProperty->keyvista,
                    'keyagua' => (int)$xmlProperty->keyagua,
                    'keycalefa' => (int)$xmlProperty->keycalefa,
                    'keycarpin' => $this->parseIntOrNull($xmlProperty->carpint),
                    'keycarpinext' => $this->parseIntOrNull($xmlProperty->carpext),
                    'keysuelo' => (int)$xmlProperty->keysuelo,
                    'keytecho' => (int)$xmlProperty->keytecho,
                    'keyfachada' => (int)$xmlProperty->keyfachada,
                    'keyelectricidad' => (int)$xmlProperty->keyelectricidad,
                    
                    // === OTROS ===
                    'keypromo' => (int)$xmlProperty->keypromo,  // ← ESTA LÍNEA FALTA
                    'destacado' => (int)$xmlProperty->destacado,
                    'estadoficha' => (int)$xmlProperty->estadoficha,
                    'electro' => (int)$xmlProperty->electro,
                    'numfotos' => (int)$xmlProperty->numfotos,
                    'tourvirtual' => !empty((string)$xmlProperty->tour),
                    'is_featured' => ((string)$xmlProperty->destacado === '1'),
                    'is_inmovilla' => true,
                    
                    // === DATOS BÁSICOS REQUERIDOS ===
                    'title' => $this->extractTitle($xmlProperty),
                    'meta_description' => $this->extractMetaDescription($xmlProperty),
                    'description' => $this->extractDescription($xmlProperty),
                    'condition' => (string)$xmlProperty->conservacion ?: 'Buena',
                    'orientation' => (string)$xmlProperty->orientacion ?: 'No especificada',
                    'exterior_type' => 'No especificado',
                    'kitchen_type' => 'No especificado', 
                    'heating_type' => 'No especificado',
                    'interior_carpentry' => (string)$xmlProperty->carpint ?: 'No especificado',
                    'exterior_carpentry' => (string)$xmlProperty->carpext ?: 'No especificado',
                    'flooring_type' => 'No especificado',
                    'views' => 'No especificadas',
                    'regime' => 'No especificado',
                ]
            );

            // === IMPORTAR DIRECCIÓN ===
            $this->importAddress($property->id, $xmlProperty);
            
            // === IMPORTAR TRADUCCIONES ===
            $this->importTranslations($property->id, $xmlProperty);
            
            // === IMPORTAR IMÁGENES ===
            $this->importImages($property->id, $xmlProperty);
            
            // === IMPORTAR VIDEOS ===
            $this->importVideos($property->id, $xmlProperty);
        });
    }

    private function importAddress($propertyId, $xmlProperty)
    {
        // Extraer coordenadas del XML
        $latitudRaw = (string)$xmlProperty->latitud;
        $longitudRaw = (string)$xmlProperty->altitud; // Inmovilla usa "altitud" para longitud
        
        // Validar y procesar coordenadas
        $latitude = null;
        $longitude = null;
        
        // Validar latitud
        if (!empty($latitudRaw) && is_numeric($latitudRaw) && $latitudRaw !== '0') {
            $lat = (float)$latitudRaw;
            if ($lat >= -90 && $lat <= 90) {
                $latitude = $lat;
            }
        }
        
        // Validar longitud
        if (!empty($longitudRaw) && is_numeric($longitudRaw) && $longitudRaw !== '0') {
            $lng = (float)$longitudRaw;
            if ($lng >= -180 && $lng <= 180) {
                $longitude = $lng;
            }
        }
        
        // Log de debug
        Log::info("IMPORTANDO DIRECCIÓN", [
            'property_id' => $propertyId,
            'ref' => (string)$xmlProperty->ref,
            'latitud_xml' => $latitudRaw,
            'longitud_xml' => $longitudRaw,
            'latitude_validada' => $latitude,
            'longitude_validada' => $longitude,
        ]);
        
        // Crear o actualizar dirección
        $address = Address::updateOrCreate(
            ['property_id' => $propertyId],
            [
                'street' => 'Sin especificar',
                'postal_code' => (string)$xmlProperty->cp,
                'city' => (string)$xmlProperty->ciudad,
                'province' => (string)$xmlProperty->provincia,
                'zone' => (string)$xmlProperty->zona,
                'latitude' => $latitude,
                'longitude' => $longitude,
            ]
        );
        
        // Confirmar guardado
        Log::info("DIRECCIÓN GUARDADA", [
            'address_id' => $address->id,
            'latitude' => $address->latitude,
            'longitude' => $address->longitude,
        ]);
        
        return $address;
    }

    private function importTranslations($propertyId, $xmlProperty)
    {
        // Mapeo idiomas Inmovilla
        $languages = [
            1 => 'es',  // titulo1, descrip1
            2 => 'en',  // titulo2, descrip2
            3 => 'de',  // titulo3, descrip3
            4 => 'fr',  // titulo4, descrip4
            5 => 'nl',  // titulo5, descrip5
        ];

        foreach ($languages as $langId => $locale) {
            $titulo = (string)$xmlProperty->{"titulo{$langId}"};
            $descrip = (string)$xmlProperty->{"descrip{$langId}"};
            
            if (!empty($titulo) || !empty($descrip)) {
                PropertyDescription::updateOrCreate(
                    [
                        'property_id' => $propertyId,
                        'inmovilla_language_id' => $langId,
                    ],
                    [
                        'locale' => $locale,
                        'title' => $titulo ?: null,
                        'description' => $descrip ?: null,
                    ]
                );
            }
        }
    }

    private function importImages($propertyId, $xmlProperty)
    {
        // Limpiar imágenes existentes
        PropertyImage::where('property_id', $propertyId)->delete();
        
        $numfotos = (int)$xmlProperty->numfotos;
        
        for ($i = 1; $i <= $numfotos; $i++) {
            $fotoElement = $xmlProperty->{"foto{$i}"};
            if (!empty($fotoElement)) {
                $url = (string)$fotoElement;
                $etiqueta = (string)$fotoElement['eti'] ?? 'general';
                
                PropertyImage::create([
                    'property_id' => $propertyId,
                    'image_path' => $url,
                    'inmovilla_url' => $url,
                    'inmovilla_photo_id' => "foto{$i}",
                    'order' => $i,
                    'is_featured' => ($i === 1),
                    'alt_text' => $etiqueta,
                ]);
            }
        }
    }

    private function importVideos($propertyId, $xmlProperty)
    {
        // Limpiar videos existentes
        PropertyVideo::where('property_id', $propertyId)->delete();
        
        if (isset($xmlProperty->videos)) {
            $order = 1;
            foreach ($xmlProperty->videos->children() as $videoElement) {
                $url = (string)$videoElement;
                if (!empty($url)) {
                    PropertyVideo::create([
                        'property_id' => $propertyId,
                        'video_url' => $url,
                        'youtube_code' => $this->extractYoutubeCode($url),
                        'title' => "Video {$order}",
                        'order' => $order,
                        'is_inmovilla' => true,
                    ]);
                    $order++;
                }
            }
        }
        
        // Tour virtual si existe
        $tour = (string)$xmlProperty->tour;
        if (!empty($tour)) {
            PropertyVideo::create([
                'property_id' => $propertyId,
                'video_url' => $tour,
                'title' => 'Tour Virtual',
                'order' => 999,
                'is_inmovilla' => true,
            ]);
        }
    }

    // === HELPERS DE MAPEO ===
    
    private function mapOperation($accion)
    {
        // Mapear texto de operación a ID en BD
        $operationMap = [
            'vender' => 'Venta',
            'alquilar' => 'Alquiler',
            'traspasar' => 'Venta', // Traspaso → Venta
        ];
        
        $operationName = $operationMap[strtolower($accion)] ?? 'Venta';
        
        $operation = \App\Models\Operation::where('name', $operationName)->first();
        
        if (!$operation) {
            Log::warning("Operación no encontrada: {$operationName}");
            return 1; // Default: primer ID disponible
        }
        
        return $operation->id;
    }

    private function mapPropertyType($tipo)
    {
        // Mapear texto de tipo a nombre EXACTO en BD (Casa, apartamento, Ático)
        $typeMap = [
            // APARTAMENTOS → apartamento (minúscula en BD)
            'apartamento' => 'apartamento',
            'piso' => 'apartamento',
            'duplex' => 'apartamento',
            'dúplex' => 'apartamento',
            'estudio' => 'apartamento',
            'loft' => 'apartamento',
            'planta baja' => 'apartamento',
            'adosado' => 'apartamento',
            'pareado' => 'apartamento',
            'triplex' => 'apartamento',
            'tríplex' => 'apartamento',
            'entresuelo' => 'apartamento',
            'piso único' => 'apartamento',
            
            // ÁTICOS → Ático (con mayúscula y tilde en BD)
            'ático' => 'Ático',
            'atico' => 'Ático',
            'ático dúplex' => 'Ático',
            'ático duplex' => 'Ático',
            'atico duplex' => 'Ático',
            'penthouse' => 'Ático',
            'semiático' => 'Ático',
            'semiatico' => 'Ático',
            'sobreático' => 'Ático',
            'sobreatico' => 'Ático',
            
            // VILLAS/CASAS → Casa (con mayúscula en BD)
            'chalet' => 'Casa',
            'casa' => 'Casa',
            'villa' => 'Casa',
            'villa de lujo' => 'Casa',  // ✅ AGREGADO
            'bungalow' => 'Casa',
            'cortijo' => 'Casa',
            'masía' => 'Casa',
            'masia' => 'Casa',
            'hacienda' => 'Casa',
            'torre' => 'Casa',
            'casa de campo' => 'Casa',
            'buhardilla' => 'Casa',
            'quad house' => 'Casa',
            'quad' => 'Casa',
            'sótano' => 'Casa',
            'sotano' => 'Casa',
            'castillo' => 'Casa',
            'casa cueva' => 'Casa',
            'casa de madera' => 'Casa',
            'caserío' => 'Casa',
            'caserio' => 'Casa',
            'casa solar' => 'Casa',
            'casa de pueblo' => 'Casa',
            'casita agrícola' => 'Casa',
            'casita agricola' => 'Casa',
            'casa terrera' => 'Casa',
            'pazo' => 'Casa',
            'casa de piedra' => 'Casa',
            'cabaña' => 'Casa',
            'cabana' => 'Casa',
            'casa con terreno' => 'Casa',
            'mansión' => 'Casa',
            'mansion' => 'Casa',
            'alquería' => 'Casa',
            'alqueria' => 'Casa',
            'residencia' => 'Casa',
            'caserón' => 'Casa',
            'caseron' => 'Casa',
            'palacio' => 'Casa',
        ];
        
        $tipoLower = mb_strtolower($tipo, 'UTF-8');
        $typeName = $typeMap[$tipoLower] ?? 'Casa'; // Default: Casa
        
        $propertyType = \App\Models\PropertyType::where('name', $typeName)->first();
        
        if (!$propertyType) {
            Log::warning("Tipo de propiedad no encontrado en BD: {$typeName} (tipo original: {$tipo})");
            return 1; // Default: primer ID disponible
        }
        
        Log::info("Tipo mapeado correctamente", [
            'tipo_original' => $tipo,
            'tipo_mapeado' => $typeName,
            'property_type_id' => $propertyType->id
        ]);
        
        return $propertyType->id;
    }

    private function mapStatus($estadoficha)
    {
        // Solo 2 estados: Disponible (1) o Reservado (2)
        $statusName = ($estadoficha == 2) ? 'Reservado' : 'Disponible';
        
        $status = \App\Models\Status::where('name', $statusName)->first();
        
        if (!$status) {
            Log::warning("Estado no encontrado: {$statusName}");
            return 1; // Default: Disponible
        }
        
        return $status->id;
    }


    private function parseDate($date)
    {
        return !empty($date) ? date('Y-m-d H:i:s', strtotime($date)) : null;
    }

    private function extractTitle($xmlProperty)
    {
        return (string)$xmlProperty->titulo1 ?: 
               (string)$xmlProperty->tipo_ofer . ' en ' . (string)$xmlProperty->ciudad;
    }

    private function extractDescription($xmlProperty)
    {
        $desc = (string)$xmlProperty->descrip1;
        return !empty($desc) ? $this->cleanText($desc) : 'Descripción no disponible';
    }

    private function extractMetaDescription($xmlProperty)
    {
        $desc = (string)$xmlProperty->descrip1;
        if (!empty($desc)) {
            $cleaned = $this->cleanText($desc);
            return mb_substr($cleaned, 0, 160, 'UTF-8');
        }
        return 'Propiedad en venta';
    }

    private function extractYoutubeCode($url)
    {
        if (preg_match('/youtube\.com\/watch\?v=([^&]+)/', $url, $matches)) {
            return $matches[1];
        }
        return null;
    }

    private function cleanText($text)
    {
        // Limpiar caracteres problemáticos
        $text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
        $text = strip_tags($text);
        $text = preg_replace('/[^\p{L}\p{N}\s\.,;:!?\-()]/u', '', $text);
        return trim($text);
    }

    private function mapConservacionToCode($texto)
    {
        $textToCode = [
            'Para reformar' => 5,
            'De origen' => 10,
            'Reformar Parcialmente' => 15,
            'Entrar a vivir' => 20,
            'Buen estado' => 30,
            'Semireformado' => 40,
            'Reformado' => 50,
            'Seminuevo' => 60,
            'Nuevo' => 70,
            'Obra Nueva' => 80,  // ← El que está fallando
            'En construcción' => 90,
            'En proyecto' => 100,
        ];
        
        return $textToCode[$texto] ?? 30; // Default: Buen estado
    }

    private function parseIntOrNull($value)
    {
        $str = (string)$value;
        return !empty($str) && is_numeric($str) ? (int)$str : null;
    }

    private function buildGoogleMapUrl($xmlProperty)
    {
        $lat = (string)$xmlProperty->latitud;
        $lng = (string)$xmlProperty->altitud;
        
        if (!empty($lat) && !empty($lng) && $lat !== '0' && $lng !== '0') {
            return "https://maps.google.com/?q={$lat},{$lng}";
        }
        return null;
    }
}