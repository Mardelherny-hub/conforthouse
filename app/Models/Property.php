<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        // Campos originales
        'reference',
        'operation_id',
        'property_type_id',
        'status_id',
        'address_id',
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
        'video',
        'description',
        'is_featured',

        // === CAMPOS DE IDENTIFICACIÓN INMOVILLA ===
        'cod_ofer',
        'inmovilla_numagencia',
        'inmovilla_ref',
        'inmovilla_fechaact',

        // === CAMPOS DE TIPO Y OPERACIÓN ===
        'inmovilla_keyacci',
        'inmovilla_key_tipo',

        // === PRECIOS Y VALORES ===
        'price_sale',
        'price_rent',
        'price_outlet',
        'rent_period',

        // === MEDIDAS ===
        'plot_area_m2',
        'useful_area_m2',
        'built_area_m2',
        'terrace_area_m2',

        // === HABITACIONES Y BAÑOS ===
        'double_rooms',
        'single_rooms',
        'total_rooms',
        'toilets',

        // === CARACTERÍSTICAS BÁSICAS ===
        'has_elevator',
        'has_air_conditioning',
        'has_heating',
        'parking_type',
        'has_community_pool',
        'has_private_pool',
        'is_diaphanous',
        'is_all_exterior',

        // === CERTIFICACIÓN ENERGÉTICA ===
        'energy_certificate_letter',
        'energy_consumption_value',
        'emissions_certificate_letter',
        'emissions_value',

        // === CAMPOS ENUM DE INMOVILLA ===
        'inmovilla_conservacion',
        'inmovilla_cocina_inde',
        'inmovilla_keyori',
        'inmovilla_keyvista',
        'inmovilla_keyagua',
        'inmovilla_keycalefa',
        'inmovilla_keycarpin',
        'inmovilla_keycarpinext',
        'inmovilla_keysuelo',
        'inmovilla_keytecho',
        'inmovilla_keyfachada',
        'inmovilla_keyelectricidad',
        'inmovilla_x_entorno',

        // === OTROS CAMPOS INMOVILLA ===
        'inmovilla_tipovpo',
        'inmovilla_electro',
        'inmovilla_destacado',
        'inmovilla_estadoficha',
        'inmovilla_eninternet',
        'inmovilla_tgascom',

        // === MULTIMEDIA ===
        'photo_count',
        'main_photo_url',
        'has_virtual_tour',
        'has_360_photos',
        'has_video_content',
        'has_before_after_photos',
        'photo_letter_id',

        // === INFORMACIÓN DE AGENCIA ===
        'agency_name',
        'agency_website',
        'agency_email',
        'agency_phone',

        // === UBICACIÓN DE INMOVILLA ===
        'inmovilla_ciudad',
        'inmovilla_zona',
        'inmovilla_key_loca',
        'inmovilla_key_zona',
        'inmovilla_keypromo',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'has_elevator' => 'boolean',
        'has_air_conditioning' => 'boolean',
        'has_heating' => 'boolean',
        'has_community_pool' => 'boolean',
        'has_private_pool' => 'boolean',
        'is_diaphanous' => 'boolean',
        'is_all_exterior' => 'boolean',
        'has_virtual_tour' => 'boolean',
        'has_360_photos' => 'boolean',
        'has_video_content' => 'boolean',
        'has_before_after_photos' => 'boolean',
        'price' => 'decimal:2',
        'price_sale' => 'decimal:2',
        'price_rent' => 'decimal:2',
        'price_outlet' => 'decimal:2',
        'community_expenses' => 'decimal:2',
        'energy_consumption_value' => 'float',
        'emissions_value' => 'float',
        'inmovilla_fechaact' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($property) {
            $property->slug = static::generateUniqueSlug($property->title);
        });
    }

    protected static function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    // === RELACIONES EXISTENTES ===
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
        return $this->hasMany(PropertyImage::class);
    }

    public function firstImage()
    {
        return $this->hasOne(PropertyImage::class)->oldestOfMany();
    }

    public function translations()
    {
        return $this->hasMany(PropertyTranslation::class);
    }

    // === MÉTODOS DE UBICACIÓN ===
    public function city()
    {
        return $this->address ? $this->address->city() : null;
    }

    public function province()
    {
        return $this->address ? $this->address->province() : null;
    }

    public function commune()
    {
        return $this->address ? $this->address->commune() : null;
    }

    public function district()
    {
        return $this->hasOneThrough(District::class, Address::class, 'id', 'id', 'address_id', 'district_id');
    }

    // === MÉTODOS ESPECÍFICOS DE INMOVILLA ===

    /**
     * Verifica si la propiedad viene de Inmovilla
     */
    public function isFromInmovilla(): bool
    {
        return !empty($this->cod_ofer);
    }

    /**
     * Obtiene el precio principal según el tipo de operación
     */
    public function getMainPrice(): ?float
    {
        // Si viene de Inmovilla, usar lógica específica
        if ($this->isFromInmovilla()) {
            return match ($this->inmovilla_keyacci) {
                2 => $this->price_rent,    // Alquiler
                1, 3 => $this->price_sale, // Venta o Traspaso
                default => $this->price    // Fallback al precio original
            };
        }
        
        return $this->price;
    }

    /**
     * Obtiene la URL del tour virtual
     */
    public function getVirtualTourUrl(): ?string
    {
        if ($this->has_virtual_tour && $this->cod_ofer && $this->inmovilla_numagencia) {
            return "http://ap.apinmo.com/fotosvr/tour.php?cod={$this->cod_ofer}.{$this->inmovilla_numagencia}";
        }
        return null;
    }

    /**
     * Obtiene la URL del visor de fotos 360
     */
    public function get360PhotosUrl(): ?string
    {
        if ($this->has_360_photos && $this->cod_ofer && $this->inmovilla_numagencia) {
            return "http://ap.apinmo.com/fotosvr/?codigo={$this->cod_ofer}.{$this->inmovilla_numagencia}";
        }
        return null;
    }

    /**
     * Decodifica las características del entorno desde el campo binario
     */
    public function getEnvironmentFeatures(): array
    {
        if (empty($this->inmovilla_x_entorno)) {
            return [];
        }

        $features = [];
        $entorno = (int) $this->inmovilla_x_entorno;

        // Mapeo según la documentación de Inmovilla
        $environmentMapping = [
            0 => 'Árboles',
            1 => 'Hospitales',
            2 => 'Tren',
            3 => 'Metro',
            4 => 'Golf',
            5 => 'Montaña',
            6 => 'Rural',
            7 => 'Costa',
            8 => 'Vallado',
            9 => 'Autobuses',
            10 => 'Centros comerciales',
            11 => 'Tranvía',
            12 => 'Zonas infantiles',
            13 => 'Colegios',
            14 => 'Céntrico',
            15 => 'Centros médicos',
            16 => 'Zona de paso',
            17 => 'Parques',
            18 => 'Cerca de Universidad',
            19 => 'Supermercados',
            20 => 'Vigilancia 24H'
        ];

        foreach ($environmentMapping as $bit => $feature) {
            $bitValue = pow(2, $bit);
            if (($entorno & $bitValue) == $bitValue) {
                $features[] = $feature;
            }
        }

        return $features;
    }

    /**
     * Verifica si tiene una característica específica del entorno
     */
    public function hasEnvironmentFeature(int $featureId): bool
    {
        if (empty($this->inmovilla_x_entorno)) {
            return false;
        }

        $bitValue = pow(2, $featureId);
        return (((int) $this->inmovilla_x_entorno) & $bitValue) == $bitValue;
    }

    /**
     * Obtiene el estado de la ficha en texto legible
     */
    public function getStatusText(): string
    {
        $statusMapping = [
            1 => 'Libre',
            2 => 'Alquilada',
            3 => 'Vendida',
            4 => 'Señalizada',
            5 => 'No Libre',
            6 => 'Traspaso',
            7 => 'Reservado',
            8 => 'En Trámites',
            9 => 'Sólo Seguimiento',
            // ... más estados según necesidad
        ];

        return $statusMapping[$this->inmovilla_estadoficha] ?? 'Desconocido';
    }

    /**
     * Scope para filtrar propiedades de Inmovilla
     */
    public function scopeFromInmovilla($query)
    {
        return $query->whereNotNull('cod_ofer');
    }

    /**
     * Scope para filtrar por tipo de operación de Inmovilla
     */
    public function scopeInmovillaOperation($query, $operationType)
    {
        return $query->where('inmovilla_keyacci', $operationType);
    }

    /**
     * Scope para filtrar propiedades actualizadas recientemente en Inmovilla
     */
    public function scopeRecentlyUpdatedInInmovilla($query, $since = null)
    {
        $since = $since ?? now()->subDay();
        return $query->where('inmovilla_fechaact', '>=', $since);
    }
}