<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

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

    // === SCOPES ÚTILES ===
    
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