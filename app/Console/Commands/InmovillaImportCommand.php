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
                    'rooms' => (int)$xmlProperty->habitaciones,
                    'bathrooms' => (int)$xmlProperty->banyos,
                    'habdobles' => (int)$xmlProperty->habdobles,
                    'aseos' => (int)$xmlProperty->aseos,
                    
                    // === CARACTERÍSTICAS BÁSICAS ===
                    'ascensor' => (bool)$xmlProperty->ascensor,
                    'aire_con' => (bool)$xmlProperty->aire_con,
                    'calefaccion' => (bool)$xmlProperty->calefaccion,
                    'parking' => (int)$xmlProperty->parking,
                    'piscina_com' => (bool)$xmlProperty->piscina_com,
                    'piscina_prop' => (bool)$xmlProperty->piscina_prop,
                    'diafano' => (bool)$xmlProperty->diafano,
                    'todoext' => (int)$xmlProperty->todoext,
                    
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
                    'conservacion' => (string)$xmlProperty->conservacion,
                    'cocina_inde' => (int)$xmlProperty->cocina_inde,
                    'keyori' => (string)$xmlProperty->orientacion,
                    'keyvista' => (int)$xmlProperty->keyvista,
                    'keyagua' => (int)$xmlProperty->keyagua,
                    'keycalefa' => (int)$xmlProperty->keycalefa,
                    'keycarpin' => (string)$xmlProperty->carpint,
                    'keycarpinext' => (string)$xmlProperty->carpext,
                    'keysuelo' => (int)$xmlProperty->keysuelo,
                    'keytecho' => (int)$xmlProperty->keytecho,
                    'keyfachada' => (int)$xmlProperty->keyfachada,
                    'keyelectricidad' => (int)$xmlProperty->keyelectricidad,
                    
                    // === OTROS ===
                    'destacado' => (int)$xmlProperty->destacado,
                    'estadoficha' => (int)$xmlProperty->estadoficha,
                    'electro' => (int)$xmlProperty->electro,
                    'numfotos' => (int)$xmlProperty->numfotos,
                    'tourvirtual' => !empty((string)$xmlProperty->tour),
                    'is_featured' => (bool)$xmlProperty->destacado,
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
        Address::updateOrCreate(
            ['property_id' => $propertyId],
            [
                'street' => 'Sin especificar', // No viene en XML, requerido en BD
                'postal_code' => (string)$xmlProperty->cp,
                'city' => (string)$xmlProperty->ciudad,
                'province' => (string)$xmlProperty->provincia,
                'zone' => (string)$xmlProperty->zona,
                'inmovilla_cp' => (string)$xmlProperty->cp,
                'inmovilla_provincia' => (string)$xmlProperty->provincia,
            ]
        );
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
        switch (strtolower($accion)) {
            case 'vender': return 1; // Venta
            case 'alquilar': return 2; // Alquiler
            case 'traspasar': return 4; // Traspaso
            default: return 1;
        }
    }

    private function mapPropertyType($tipo)
    {
        // Mapeo básico - puedes expandir según necesites
        switch (strtolower($tipo)) {
            case 'chalet':
            case 'casa': return 1; // Casa
            case 'apartamento':
            case 'piso': return 2; // Departamento
            case 'ático': return 3; // Ático
            case 'obra nueva': return 4; // Obra Nueva
            case 'adosado': return 5; // Adosado
            default: return 1;
        }
    }

    private function mapStatus($estadoficha)
    {
        switch ($estadoficha) {
            case 1: return 1; // Disponible
            case 2: return 2; // Reservado
            default: return 1;
        }
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
}