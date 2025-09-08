<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PropertyTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        // Campos originales
        'property_id',
        'locale',
        'title',
        'slug',
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

        // === NUEVOS CAMPOS TRADUCIBLES DE INMOVILLA ===
        'water_heating_type',           // Traducción del tipo de agua caliente (inmovilla_keyagua)
        'heating_system_type',          // Traducción del sistema de calefacción (inmovilla_keycalefa)
        'interior_carpentry_material',  // Material carpintería interior (inmovilla_keycarpin)
        'exterior_carpentry_material',  // Material carpintería exterior (inmovilla_keycarpinext)
        'floor_material',               // Material de suelos (inmovilla_keysuelo)
        'ceiling_type',                 // Tipo de techos (inmovilla_keytecho)
        'facade_type',                  // Tipo de fachada (inmovilla_keyfachada)
        'electrical_system',            // Sistema eléctrico (inmovilla_keyelectricidad)
        'conservation_state',           // Estado de conservación (inmovilla_conservacion)
        'kitchen_style',                // Estilo de cocina (inmovilla_cocina_inde)
        'appliances_included',          // Electrodomésticos incluidos (inmovilla_electro)
        'environment_features',         // Características del entorno (inmovilla_x_entorno decodificado)
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($translation) {
            $translation->slug = static::generateUniqueSlug($translation->title, $translation->locale);
        });

        static::updating(function ($translation) {
            if ($translation->isDirty('title')) {
                $translation->slug = static::generateUniqueSlug($translation->title, $translation->locale, $translation->id);
            }
        });
    }

    protected static function generateUniqueSlug($title, $locale, $excludeId = null)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Validar que no exista ya ese slug para el mismo locale
        $query = static::where('slug', $slug)->where('locale', $locale);
        
        if ($excludeId) {
            $query->where('id', '!=', $excludeId);
        }

        while ($query->exists()) {
            $slug = $originalSlug . '-' . $counter++;
            $query = static::where('slug', $slug)->where('locale', $locale);
            if ($excludeId) {
                $query->where('id', '!=', $excludeId);
            }
        }

        return $slug;
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // === MÉTODOS PARA MAPEAR CAMPOS DE INMOVILLA A TRADUCCIONES ===

    /**
     * Mapea el valor de agua caliente de Inmovilla a texto traducible
     */
    public static function mapWaterHeatingType(int $keyagua, string $locale = 'es'): string
    {
        $mapping = [
            1 => ['es' => 'No Tiene', 'en' => 'No water heating', 'fr' => 'Pas de chauffage eau', 'de' => 'Keine Warmwasser'],
            2 => ['es' => 'Central', 'en' => 'Central', 'fr' => 'Central', 'de' => 'Zentral'],
            3 => ['es' => 'Termo Eléctrico', 'en' => 'Electric Heater', 'fr' => 'Chauffe-eau électrique', 'de' => 'Elektrischer Warmwasserbereiter'],
            4 => ['es' => 'Calentador Butano', 'en' => 'Butane Heater', 'fr' => 'Chauffe-eau butane', 'de' => 'Butan-Warmwasserbereiter'],
            5 => ['es' => 'Gas Natural', 'en' => 'Natural Gas', 'fr' => 'Gaz naturel', 'de' => 'Erdgas'],
            6 => ['es' => 'Gas Propano', 'en' => 'Propane Gas', 'fr' => 'Gaz propane', 'de' => 'Propangas'],
            7 => ['es' => 'Gasoil', 'en' => 'Diesel Oil', 'fr' => 'Fioul', 'de' => 'Heizöl'],
            8 => ['es' => 'Gas Ciudad', 'en' => 'City Gas', 'fr' => 'Gaz de ville', 'de' => 'Stadtgas'],
            9 => ['es' => 'Placas Solares', 'en' => 'Solar Panels', 'fr' => 'Panneaux solaires', 'de' => 'Solarmodule'],
            10 => ['es' => 'Biomasa', 'en' => 'Biomass', 'fr' => 'Biomasse', 'de' => 'Biomasse'],
            11 => ['es' => 'Aerotermia', 'en' => 'Aerothermal', 'fr' => 'Aérothermie', 'de' => 'Aerothermie'],
            12 => ['es' => 'Geotermia', 'en' => 'Geothermal', 'fr' => 'Géothermie', 'de' => 'Geothermie'],
            13 => ['es' => 'Central con contador individual', 'en' => 'Central with individual meter', 'fr' => 'Central avec compteur individuel', 'de' => 'Zentral mit Einzelzähler'],
            14 => ['es' => 'Pellets', 'en' => 'Pellets', 'fr' => 'Granulés', 'de' => 'Pellets'],
            15 => ['es' => 'Bomba de calor', 'en' => 'Heat pump', 'fr' => 'Pompe à chaleur', 'de' => 'Wärmepumpe'],
        ];

        return $mapping[$keyagua][$locale] ?? $mapping[$keyagua]['es'] ?? '';
    }

    /**
     * Mapea el valor de conservación de Inmovilla a texto traducible
     */
    public static function mapConservationState(int $conservacion, string $locale = 'es'): string
    {
        $mapping = [
            5 => ['es' => 'Para reformar', 'en' => 'To refurbish', 'fr' => 'À rénover', 'de' => 'Zu renovieren'],
            10 => ['es' => 'De origen', 'en' => 'From origin', 'fr' => "D'origine", 'de' => 'Original'],
            15 => ['es' => 'Reformar Parcialmente', 'en' => 'Partially refurbish', 'fr' => 'Rénover partiellement', 'de' => 'Teilweise renovieren'],
            20 => ['es' => 'Entrar a vivir', 'en' => 'Ready to move in', 'fr' => 'Prêt à habiter', 'de' => 'Bezugsfertig'],
            30 => ['es' => 'Buen estado', 'en' => 'Good condition', 'fr' => 'Bon état', 'de' => 'Guter Zustand'],
            40 => ['es' => 'Semireformado', 'en' => 'Partially refurbished', 'fr' => 'Semi-rénové', 'de' => 'Teilweise renoviert'],
            50 => ['es' => 'Reformado', 'en' => 'Refurbished', 'fr' => 'Rénové', 'de' => 'Renoviert'],
            60 => ['es' => 'Seminuevo', 'en' => 'Semi new', 'fr' => 'Semi neuf', 'de' => 'Halbneu'],
            70 => ['es' => 'Nuevo', 'en' => 'New', 'fr' => 'Neuf', 'de' => 'Neu'],
            80 => ['es' => 'Obra Nueva', 'en' => 'New Build', 'fr' => 'Construction neuve', 'de' => 'Neubau'],
            90 => ['es' => 'En construcción', 'en' => 'Under construction', 'fr' => 'En construction', 'de' => 'Im Bau'],
            100 => ['es' => 'En proyecto', 'en' => 'Off-plan', 'fr' => 'En projet', 'de' => 'In Planung'],
        ];

        return $mapping[$conservacion][$locale] ?? $mapping[$conservacion]['es'] ?? '';
    }

    /**
     * Mapea el tipo de cocina de Inmovilla a texto traducible
     */
    public static function mapKitchenStyle(int $cocinaInde, string $locale = 'es'): string
    {
        $mapping = [
            1 => ['es' => 'Independiente', 'en' => 'Independent', 'fr' => 'Indépendante', 'de' => 'Unabhängig'],
            2 => ['es' => 'Exterior', 'en' => 'External', 'fr' => 'Extérieure', 'de' => 'Außen'],
            3 => ['es' => 'Americana', 'en' => 'American', 'fr' => 'Américaine', 'de' => 'Amerikanisch'],
            4 => ['es' => 'Salón Cocina', 'en' => 'Open kitchen', 'fr' => 'Cuisine ouverte', 'de' => 'Offene Küche'],
            5 => ['es' => 'Francesa', 'en' => 'French', 'fr' => 'Française', 'de' => 'Französisch'],
            6 => ['es' => 'Cocina Office', 'en' => 'Kitchen Office', 'fr' => 'Cuisine bureau', 'de' => 'Küche Büro'],
            7 => ['es' => 'Con isla', 'en' => 'With island', 'fr' => 'Avec îlot', 'de' => 'Mit Kochinsel'],
        ];

        return $mapping[$cocinaInde][$locale] ?? $mapping[$cocinaInde]['es'] ?? '';
    }

    /**
     * Mapea electrodomésticos incluidos
     */
    public static function mapAppliancesIncluded(int $electro, string $locale = 'es'): string
    {
        $mapping = [
            1 => ['es' => 'Equipada', 'en' => 'Equipped', 'fr' => 'Équipée', 'de' => 'Ausgestattet'],
            2 => ['es' => 'Vacía', 'en' => 'Empty', 'fr' => 'Vide', 'de' => 'Leer'],
            3 => ['es' => 'Sólo muebles', 'en' => 'Only furniture', 'fr' => 'Meubles seulement', 'de' => 'Nur Möbel'],
        ];

        return $mapping[$electro][$locale] ?? $mapping[$electro]['es'] ?? '';
    }

    /**
     * Mapea orientación desde código Inmovilla
     */
    public static function mapOrientation(int $keyori, string $locale = 'es'): string
    {
        $mapping = [
            1 => ['es' => 'Norte', 'en' => 'North', 'fr' => 'Nord', 'de' => 'Norden'],
            2 => ['es' => 'Sur', 'en' => 'South', 'fr' => 'Sud', 'de' => 'Süden'],
            3 => ['es' => 'Este', 'en' => 'East', 'fr' => 'Est', 'de' => 'Osten'],
            4 => ['es' => 'Oeste', 'en' => 'West', 'fr' => 'Ouest', 'de' => 'Westen'],
            5 => ['es' => 'Noroeste', 'en' => 'Northwest', 'fr' => 'Nord-ouest', 'de' => 'Nordwesten'],
            6 => ['es' => 'Suroeste', 'en' => 'Southwest', 'fr' => 'Sud-ouest', 'de' => 'Südwesten'],
            7 => ['es' => 'Este Oeste', 'en' => 'East West', 'fr' => 'Est Ouest', 'de' => 'Ost West'],
            8 => ['es' => 'Sureste', 'en' => 'Southeast', 'fr' => 'Sud-est', 'de' => 'Südosten'],
            9 => ['es' => 'Norte Sur', 'en' => 'North South', 'fr' => 'Nord Sud', 'de' => 'Nord Süd'],
            10 => ['es' => 'Noreste', 'en' => 'Northeast', 'fr' => 'Nord-est', 'de' => 'Nordosten'],
        ];

        return $mapping[$keyori][$locale] ?? $mapping[$keyori]['es'] ?? '';
    }

    /**
     * Decodifica y traduce las características del entorno
     */
    public static function mapEnvironmentFeatures(int $xEntorno, string $locale = 'es'): string
    {
        $environmentMapping = [
            0 => ['es' => 'Árboles', 'en' => 'Trees', 'fr' => 'Arbres', 'de' => 'Bäume'],
            1 => ['es' => 'Hospitales', 'en' => 'Hospitals', 'fr' => 'Hôpitaux', 'de' => 'Krankenhäuser'],
            2 => ['es' => 'Tren', 'en' => 'Train', 'fr' => 'Train', 'de' => 'Zug'],
            3 => ['es' => 'Metro', 'en' => 'Underground', 'fr' => 'Métro', 'de' => 'U-Bahn'],
            4 => ['es' => 'Golf', 'en' => 'Golf', 'fr' => 'Golf', 'de' => 'Golf'],
            5 => ['es' => 'Montaña', 'en' => 'Mountain', 'fr' => 'Montagne', 'de' => 'Berg'],
            6 => ['es' => 'Rural', 'en' => 'Rural', 'fr' => 'Rural', 'de' => 'Ländlich'],
            7 => ['es' => 'Costa', 'en' => 'Coast', 'fr' => 'Côte', 'de' => 'Küste'],
            8 => ['es' => 'Vallado', 'en' => 'Fenced', 'fr' => 'Clôturé', 'de' => 'Eingezäunt'],
            9 => ['es' => 'Autobuses', 'en' => 'Buses', 'fr' => 'Bus', 'de' => 'Busse'],
            10 => ['es' => 'Centros comerciales', 'en' => 'Shopping centers', 'fr' => 'Centres commerciaux', 'de' => 'Einkaufszentren'],
            11 => ['es' => 'Tranvía', 'en' => 'Tram', 'fr' => 'Tramway', 'de' => 'Straßenbahn'],
            12 => ['es' => 'Zonas infantiles', 'en' => 'Kids zones', 'fr' => 'Zones enfants', 'de' => 'Kinderbereiche'],
            13 => ['es' => 'Colegios', 'en' => 'Schools', 'fr' => 'Écoles', 'de' => 'Schulen'],
            14 => ['es' => 'Céntrico', 'en' => 'Central', 'fr' => 'Central', 'de' => 'Zentral'],
            15 => ['es' => 'Centros médicos', 'en' => 'Medical centers', 'fr' => 'Centres médicaux', 'de' => 'Medizinische Zentren'],
            16 => ['es' => 'Zona de paso', 'en' => 'Transit area', 'fr' => 'Zone de passage', 'de' => 'Durchgangsbereich'],
            17 => ['es' => 'Parques', 'en' => 'Parks', 'fr' => 'Parcs', 'de' => 'Parks'],
            18 => ['es' => 'Cerca de Universidad', 'en' => 'Near University', 'fr' => 'Près université', 'de' => 'Nähe Universität'],
            19 => ['es' => 'Supermercados', 'en' => 'Supermarkets', 'fr' => 'Supermarchés', 'de' => 'Supermärkte'],
            20 => ['es' => 'Vigilancia 24H', 'en' => '24H surveillance', 'fr' => 'Surveillance 24H', 'de' => '24H Überwachung'],
        ];

        $features = [];
        foreach ($environmentMapping as $bit => $feature) {
            $bitValue = pow(2, $bit);
            if (($xEntorno & $bitValue) == $bitValue) {
                $features[] = $feature[$locale] ?? $feature['es'];
            }
        }

        return implode(', ', $features);
    }

    /**
     * Actualiza campos traducibles automáticamente desde una propiedad
     */
    public function updateFromProperty(Property $property): void
    {
        // Mapear campos automáticamente si la propiedad viene de Inmovilla
        if ($property->isFromInmovilla()) {
            if ($property->inmovilla_keyagua) {
                $this->water_heating_type = static::mapWaterHeatingType($property->inmovilla_keyagua, $this->locale);
            }
            
            if ($property->inmovilla_conservacion) {
                $this->conservation_state = static::mapConservationState($property->inmovilla_conservacion, $this->locale);
            }
            
            if ($property->inmovilla_cocina_inde) {
                $this->kitchen_style = static::mapKitchenStyle($property->inmovilla_cocina_inde, $this->locale);
            }
            
            if ($property->inmovilla_electro) {
                $this->appliances_included = static::mapAppliancesIncluded($property->inmovilla_electro, $this->locale);
            }
            
            if ($property->inmovilla_keyori) {
                $this->orientation = static::mapOrientation($property->inmovilla_keyori, $this->locale);
            }
            
            if ($property->inmovilla_x_entorno) {
                $this->environment_features = static::mapEnvironmentFeatures($property->inmovilla_x_entorno, $this->locale);
            }
        }
    }
}