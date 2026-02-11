<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        // === CAMPOS LARAVEL ORIGINALES ===
        'reference',
        'operation_id',
        'property_type_id',
        'status_id',
        'is_featured',
        'title',
        'slug',
        'meta_description',
        'price',
        'community_expenses',
        'built_area',
        'condition',
        'rooms',
        'bathrooms',
        'year_built',
        'parking_spaces',
        'floors',
        'floor',
        'orientation',
        'exterior_type',
        'kitchen_type',
        'heating_type',
        'interior_carpentry',
        'exterior_carpentry',
        'flooring_type',
        'views',
        'distance_to_sea',
        'regime',
        'google_map',
        'description',
        'video',

        // === CAMPOS INMOVILLA AGREGADOS ===
        'cod_ofer',
        'inmovilla_ref',
        'numagencia',
        'fechaact',
        'keyacci',
        'key_tipo',
        'nbtipo',
        'precioinmo',
        'precioalq',
        'outlet',
        'tipomensual',
        'm_parcela',
        'm_uties',
        'm_terraza',
        'habdobles',
        'habitaciones_simples',
        'total_hab',
        'aseos',
        'ascensor',
        'aire_con',
        'calefaccion',
        'parking',
        'piscina_com',
        'piscina_prop',
        'diafano',
        'todoext',
        // === CARACTERÍSTICAS ADICIONALES BOOLEANAS ===
        'balcon',
        'bar',
        'jardin',
        'barbacoa',
        'cajafuerte',
        'calefacentral',
        'chimenea',
        'depoagua',
        'descalcificador',
        'despensa',
        'esquina',
        'galeria',
        'garajedoble',
        'gasciudad',
        'gimnasio',
        'habjuegos',
        'hidromasaje',
        'jacuzzi',
        'lavanderia',
        'linea_tlf',
        'luminoso',
        'luz',
        'muebles',
        'ojobuey',
        'patio',
        'preinstaacc',
        'primera_line',
        'puerta_blin',
        'satelite',
        'sauna',
        'solarium',
        'sotano',
        'mirador',
        'apartseparado',
        'bombafriocalor',
        'buhardilla',
        'pergola',
        'tv',
        'terraza',
        'terrazaacris',
        'trastero',
        'urbanizacion',
        'vestuarios',
        'vistasalmar',
        'plaza_gara',
        'nplazasparking',
        'ibi',
        'anoconstr',
        'garajes',
        'energialetra',
        'energiavalor',
        'emisionesletra',
        'emisionesvalor',
        'conservacion',
        'cocina_inde',
        'keyori',
        'keyvista',
        'keyagua',
        'keycalefa',
        'keycarpin',
        'keycarpinext',
        'keysuelo',
        'keytecho',
        'keyfachada',
        'keyelectricidad',
        'x_entorno',
        'tipovpo',
        'electro',
        'destacado',
        'estadoficha',
        'eninternet',
        'tgascom',
        'numfotos',
        'foto',
        'tourvirtual',
        'fotos360',
        'video_inmovilla',
        'antesydespues',
        'fotoletra',
        'agencia',
        'web',
        'emailagencia',
        'telefono',
        'ciudad_inmovilla',
        'zona_inmovilla',
        'key_loca',
        'key_zona',
        'keypromo',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'community_expenses' => 'decimal:2',
        'precioinmo' => 'decimal:2',
        'precioalq' => 'decimal:2',
        'outlet' => 'decimal:2',
        'energiavalor' => 'float',
        'emisionesvalor' => 'float',
        'ascensor' => 'boolean',
        'aire_con' => 'boolean',
        'calefaccion' => 'boolean',
        'piscina_com' => 'boolean',
        'piscina_prop' => 'boolean',
        'diafano' => 'boolean',
        'todoext' => 'boolean',
        'tourvirtual' => 'boolean',
        'fotos360' => 'boolean',
        'video_inmovilla' => 'boolean',
        'antesydespues' => 'boolean',
        'fechaact' => 'datetime',
        // === NUEVOS CAMPOS BOOLEANOS ===
        'balcon' => 'boolean',
        'bar' => 'boolean',
        'jardin' => 'boolean',
        'barbacoa' => 'boolean',
        'cajafuerte' => 'boolean',
        'calefacentral' => 'boolean',
        'chimenea' => 'boolean',
        'depoagua' => 'boolean',
        'descalcificador' => 'boolean',
        'despensa' => 'boolean',
        'esquina' => 'boolean',
        'galeria' => 'boolean',
        'garajedoble' => 'boolean',
        'gasciudad' => 'boolean',
        'gimnasio' => 'boolean',
        'habjuegos' => 'boolean',
        'hidromasaje' => 'boolean',
        'jacuzzi' => 'boolean',
        'lavanderia' => 'boolean',
        'linea_tlf' => 'boolean',
        'luminoso' => 'boolean',
        'luz' => 'boolean',
        'muebles' => 'boolean',
        'ojobuey' => 'boolean',
        'patio' => 'boolean',
        'preinstaacc' => 'boolean',
        'primera_line' => 'boolean',
        'puerta_blin' => 'boolean',
        'satelite' => 'boolean',
        'sauna' => 'boolean',
        'solarium' => 'boolean',
        'sotano' => 'boolean',
        'mirador' => 'boolean',
        'apartseparado' => 'boolean',
        'bombafriocalor' => 'boolean',
        'buhardilla' => 'boolean',
        'pergola' => 'boolean',
        'tv' => 'boolean',
        'terraza' => 'boolean',
        'terrazaacris' => 'boolean',
        'trastero' => 'boolean',
        'urbanizacion' => 'boolean',
        'vestuarios' => 'boolean',
        'vistasalmar' => 'boolean',
        'ibi' => 'decimal:2',
    ];

    /**
     * Obtener el nombre real del subtipo de propiedad según key_tipo de Inmovilla
     */
    public function getSubtipoNameAttribute(): string
    {
        $locale = app()->getLocale();
        
        $subtipos = [
            'es' => [
                199  => 'Adosado',
                999  => 'Pareado',
                2799 => 'Apartamento',
                2999 => 'Dúplex',
                3099 => 'Estudio',
                3199 => 'Habitación',
                3299 => 'Loft',
                3399 => 'Piso',
                3499 => 'Planta Baja',
                3599 => 'Triplex',
                4899 => 'Entresuelo',
                9699 => 'Piso Único',
                2899 => 'Ático',
                4399 => 'Ático Dúplex',
                4799 => 'Semiático',
                20999 => 'Sobreático',
                299  => 'Bungalow',
                399  => 'Casa',
                499  => 'Chalet',
                599  => 'Cortijo',
                699  => 'Hacienda',
                899  => 'Masía',
                1099 => 'Torre',
                4599 => 'Casa de Campo',
                4999 => 'Villa',
                6499 => 'Villa de Lujo',
                5699 => 'Castillo',
                20099 => 'Mansión',
            ],
            'en' => [
                199  => 'Townhouse',
                999  => 'Semi-detached',
                2799 => 'Apartment',
                2999 => 'Duplex',
                3099 => 'Studio',
                3199 => 'Room',
                3299 => 'Loft',
                3399 => 'Flat',
                3499 => 'Ground Floor',
                3599 => 'Triplex',
                4899 => 'Mezzanine',
                9699 => 'Single Floor Flat',
                2899 => 'Penthouse',
                4399 => 'Duplex Penthouse',
                4799 => 'Semi-penthouse',
                20999 => 'Top Floor',
                299  => 'Bungalow',
                399  => 'House',
                499  => 'Chalet',
                599  => 'Country House',
                699  => 'Hacienda',
                899  => 'Farmhouse',
                1099 => 'Tower House',
                4599 => 'Country House',
                4999 => 'Villa',
                6499 => 'Luxury Villa',
                5699 => 'Castle',
                20099 => 'Mansion',
            ],
            'fr' => [
                199  => 'Maison mitoyenne',
                999  => 'Maison jumelée',
                2799 => 'Appartement',
                2999 => 'Duplex',
                3099 => 'Studio',
                3199 => 'Chambre',
                3299 => 'Loft',
                3399 => 'Appartement',
                3499 => 'Rez-de-chaussée',
                3599 => 'Triplex',
                4899 => 'Entresol',
                9699 => 'Appartement plain-pied',
                2899 => 'Attique',
                4399 => 'Attique duplex',
                4799 => 'Semi-attique',
                20999 => 'Dernier étage',
                299  => 'Bungalow',
                399  => 'Maison',
                499  => 'Chalet',
                599  => 'Maison de campagne',
                699  => 'Hacienda',
                899  => 'Mas',
                1099 => 'Tour',
                4599 => 'Maison de campagne',
                4999 => 'Villa',
                6499 => 'Villa de luxe',
                5699 => 'Château',
                20099 => 'Manoir',
            ],
            'nl' => [
                199  => 'Rijwoning',
                999  => 'Twee-onder-een-kap',
                2799 => 'Appartement',
                2999 => 'Duplex',
                3099 => 'Studio',
                3199 => 'Kamer',
                3299 => 'Loft',
                3399 => 'Appartement',
                3499 => 'Begane grond',
                3599 => 'Triplex',
                4899 => 'Tussenverdieping',
                9699 => 'Gelijkvloers appartement',
                2899 => 'Penthouse',
                4399 => 'Duplex penthouse',
                4799 => 'Semi-penthouse',
                20999 => 'Bovenste verdieping',
                299  => 'Bungalow',
                399  => 'Huis',
                499  => 'Chalet',
                599  => 'Landhuis',
                699  => 'Hacienda',
                899  => 'Boerderij',
                1099 => 'Torenwoning',
                4599 => 'Landhuis',
                4999 => 'Villa',
                6499 => 'Luxe villa',
                5699 => 'Kasteel',
                20099 => 'Landhuis',
            ],
            'de' => [
                199  => 'Reihenhaus',
                999  => 'Doppelhaushälfte',
                2799 => 'Wohnung',
                2999 => 'Duplex',
                3099 => 'Studio',
                3199 => 'Zimmer',
                3299 => 'Loft',
                3399 => 'Wohnung',
                3499 => 'Erdgeschoss',
                3599 => 'Triplex',
                4899 => 'Zwischengeschoss',
                9699 => 'Etagenwohnung',
                2899 => 'Penthouse',
                4399 => 'Duplex-Penthouse',
                4799 => 'Semi-Penthouse',
                20999 => 'Dachgeschoss',
                299  => 'Bungalow',
                399  => 'Haus',
                499  => 'Chalet',
                599  => 'Landhaus',
                699  => 'Hacienda',
                899  => 'Bauernhaus',
                1099 => 'Turmhaus',
                4599 => 'Landhaus',
                4999 => 'Villa',
                6499 => 'Luxusvilla',
                5699 => 'Schloss',
                20099 => 'Herrenhaus',
            ],
        ];

        $map = $subtipos[$locale] ?? $subtipos['en'] ?? [];
        
        return $map[$this->key_tipo] ?? ($this->propertyType->name ?? 'N/A');
    }

    // === RELACIONES LARAVEL EXISTENTES ===
    
    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function address()
    {
        return $this->hasOne(Address::class);
    }

    public function images()
    {
        return $this->hasMany(PropertyImage::class)->orderBy('order');
    }

    public function firstImage()
    {
        return $this->hasOne(PropertyImage::class)->where('is_featured', true)->latest();
    }

    public function translations()
    {
        return $this->hasMany(PropertyTranslation::class);
    }

    // === NUEVAS RELACIONES INMOVILLA ===
    
    public function videos()
    {
        return $this->hasMany(PropertyVideo::class)->orderBy('order');
    }

    public function descriptions()
    {
        return $this->hasMany(PropertyDescription::class);
    }

    /**
     * Obtiene el tipo de propiedad mapeado desde Inmovilla
     */
    public function getMappedPropertyType()
    {
        $mapping = config('inmovilla.property_type_mapping');
        return $mapping[$this->key_tipo] ?? $this->nbtipo ?? 'Complejo Residencial';
    }

    // === SCOPES ÚTILES ===



    /**
     * Obtiene el nombre corto del complejo
     */
    public function getComplexNameAttribute()
    {
        if (!$this->keypromo) {
            return null;
        }
        
        // Obtener el primer título del grupo por keypromo
        $complexTitle = Property::where('keypromo', $this->keypromo)
            ->orderBy('reference')
            ->value('title');
            
        if (!$complexTitle) {
            return null;
        }
        
        // Extraer nombre corto del título
        return $this->extractComplexName($complexTitle);
    }

    /**
     * Extrae nombre corto del título completo
     */
    private function extractComplexName($title)
    {
        // Casos específicos basados en tu data
        if (str_contains($title, 'La Isla')) return 'La Isla';
        if (str_contains($title, 'Talasa Terra')) return 'Talasa Terra';
        if (str_contains($title, 'Talasa Caelus')) return 'Talasa Caelus';
        if (str_contains($title, 'Sunset Sailors')) return 'Sunset Sailors';
        if (str_contains($title, 'SaliSol Golf')) return 'SaliSol Golf';
        if (str_contains($title, 'Villa Altair')) return 'Villa Altair';
        if (str_contains($title, 'Golden Leaves')) return 'Golden Leaves';
        if (str_contains($title, 'Apple Bay')) return 'Apple Bay';
        if (str_contains($title, 'Sunrise Bay')) return 'Sunrise Bay';
        if (str_contains($title, 'Isea Views')) return 'Isea Views';
        if (str_contains($title, 'Benidorm Beach')) return 'Benidorm Beach';
        
        // Para títulos genéricos como "Ático Dúplex en X", usar la ciudad
        if (preg_match('/en ([A-Z][a-z\s]+)/', $title, $matches)) {
            return trim($matches[1]);
        }
        
        // Fallback: primeras 3 palabras del título
        return implode(' ', array_slice(explode(' ', $title), 0, 3));
    }

    public function scopeLuxury($query)
    {
        return $query->where('precioinmo', '>=', 1000000);
    }
    
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeAvailable($query)
    {
        return $query->whereHas('status', function($q) {
            $q->where('name', 'Disponible');
        });
    }

    public function scopeByOperation($query, $operationId)
    {
        return $query->where('operation_id', $operationId);
    }

    public function scopeByType($query, $typeId)
    {
        return $query->where('property_type_id', $typeId);
    }

    public function scopePriceRange($query, $min = null, $max = null)
    {
        if ($min) {
            $query->where('price', '>=', $min);
        }
        if ($max) {
            $query->where('price', '<=', $max);
        }
        return $query;
    }

    public function scopeInmovilla($query)
    {
        return $query->whereNotNull('cod_ofer');
    }

    // === ACCESSORS INTELIGENTES (COMPATIBILIDAD) ===
    
    /**
     * Precio principal inteligente - prioriza venta sobre alquiler
     */
    public function getMainPriceAttribute()
    {
        return $this->precioinmo ?? $this->precioalq ?? $this->price;
    }

    /**
     * Referencia unificada - usa Inmovilla si existe, sino Laravel
     */
    public function getMainReferenceAttribute()
    {
        return $this->inmovilla_ref ?? $this->reference;
    }

    /**
     * Superficie construida unificada
     */
    public function getMainBuiltAreaAttribute()
    {
        return $this->built_area ?? 0;
    }

    /**
     * Total habitaciones calculado
     */
    public function getTotalRoomsAttribute()
    {
        return $this->total_hab ?? $this->rooms ?? 0;
    }

    /**
     * Ciudad unificada
     */
    public function getMainCityAttribute()
    {
        return $this->ciudad_inmovilla ?? $this->address?->city ?? 'Sin ciudad';
    }

    /**
     * Zona unificada
     */
    public function getMainZoneAttribute()
    {
        return $this->zona_inmovilla ?? $this->address?->district ?? null;
    }

    /**
     * URL foto principal
     */
    public function getMainPhotoAttribute()
    {
        return $this->foto ?? $this->firstImage?->image_path ?? null;
    }

    /**
     * Es propiedad destacada (combina ambos sistemas)
     */
    public function getIsHighlightedAttribute()
    {
        return $this->is_featured || $this->destacado;
    }

    /**
     * Operación en texto (para compatibilidad)
     */
    public function getOperationNameAttribute()
    {
        $operations = [
            1 => 'Venta',
            2 => 'Alquiler', 
            3 => 'Traspaso',
            4 => 'Leasing'
        ];
        
        return $operations[$this->keyacci] ?? $this->operation?->name ?? 'Venta';
    }

    /**
     * Tipo de propiedad en texto (para compatibilidad)
     */
    public function getPropertyTypeNameAttribute()
    {
        return $this->nbtipo ?? $this->propertyType?->name ?? 'Casa';
    }

    // === MUTATORS PARA AUTOMATIZACIÓN ===
    
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        // Auto-generar slug si no existe
        if (empty($this->attributes['slug'])) {
            $this->attributes['slug'] = Str::slug($value) . '-' . ($this->cod_ofer ?? rand(1000, 9999));
        }
    }

    // === MÉTODOS HELPER ===
    
    /**
     * Verifica si la propiedad viene de Inmovilla
     */
    public function isFromInmovilla(): bool
    {
        return !empty($this->cod_ofer);
    }

    /**
     * Obtiene el precio formateado principal
     */
    public function getFormattedMainPrice(): string
    {
        $price = $this->getMainPriceAttribute();
        return $price ? '€' . number_format($price, 0, ',', '.') : 'Consultar';
    }

    /**
     * Obtiene la descripción de conservación
     */
    public function getConservationDescription(): string
    {
        $states = [
            5 => 'Para reformar',
            10 => 'De origen',
            15 => 'Reformar parcialmente', 
            20 => 'Entrar a vivir',
            30 => 'Buen estado',
            40 => 'Semireformado',
            50 => 'Reformado',
            60 => 'Seminuevo',
            70 => 'Nuevo',
            80 => 'Obra nueva',
            90 => 'En construcción',
            100 => 'En proyecto'
        ];
        
        return $states[$this->conservacion] ?? $this->condition ?? 'Buen estado';
    }

    /**
     * Verifica si tiene características premium
     */
    public function hasPremiumFeatures(): bool
    {
        return $this->piscina_prop || $this->piscina_com || $this->ascensor || 
               $this->aire_con || $this->garajes > 0 || $this->distance_to_sea < 1000;
    }

    /**
     * Obtiene resumen de características
     */
    public function getFeaturesSummary(): array
    {
        $features = [];
        
        if ($this->getTotalRoomsAttribute() > 0) {
            $features[] = $this->getTotalRoomsAttribute() . ' hab.';
        }
        
        if ($this->bathrooms > 0) {
            $features[] = $this->bathrooms . ' baños';
        }
        
        if ($this->getMainBuiltAreaAttribute() > 0) {
            $features[] = $this->getMainBuiltAreaAttribute() . 'm²';
        }
        
        if ($this->garajes > 0) {
            $features[] = $this->garajes . ' garaje';
        }
        
        return $features;
    }

    // === EVENTOS DEL MODELO ===
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($property) {
            // Auto-generar reference si no existe
            if (empty($property->reference)) {
                $property->reference = 'PROP-' . strtoupper(Str::random(8));
            }
            
            // Auto-generar slug si no existe
            if (empty($property->slug) && !empty($property->title)) {
                $property->slug = Str::slug($property->title) . '-' . ($property->cod_ofer ?? rand(1000, 9999));
            }
        });
    }
}