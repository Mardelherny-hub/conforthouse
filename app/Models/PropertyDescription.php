<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyDescription extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'inmovilla_language_id',
        'locale',
        'title',
        'description',
    ];

    // === RELACIONES ===
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // === SCOPES ===
    
    public function scopeByLocale($query, $locale)
    {
        return $query->where('locale', $locale);
    }

    public function scopeByInmovillaLanguage($query, $languageId)
    {
        return $query->where('inmovilla_language_id', $languageId);
    }

    // === MAPEO DE IDIOMAS INMOVILLA ===
    
    /**
     * Mapeo entre IDs de idioma Inmovilla y locales Laravel
     */
    public static function getInmovillaLanguageMapping(): array
    {
        return [
            1 => 'es',    // Español
            2 => 'en',    // Inglés  
            3 => 'fr',    // Francés
            4 => 'de',    // Alemán
            5 => 'it',    // Italiano
            6 => 'pt',    // Portugués
            7 => 'ru',    // Ruso
            8 => 'nl',    // Holandés
            // Agregar más según necesidades
        ];
    }

    /**
     * Mapeo inverso: de locale a ID Inmovilla
     */
    public static function getLocaleToInmovillaMapping(): array
    {
        return array_flip(self::getInmovillaLanguageMapping());
    }

    // === ACCESSORS ===
    
    /**
     * Obtiene el nombre del idioma en español
     */
    public function getLanguageNameAttribute(): string
    {
        $names = [
            'es' => 'Español',
            'en' => 'Inglés',
            'fr' => 'Francés', 
            'de' => 'Alemán',
            'it' => 'Italiano',
            'pt' => 'Portugués',
            'ru' => 'Ruso',
            'nl' => 'Holandés',
        ];
        
        return $names[$this->locale] ?? 'Desconocido';
    }

    /**
     * Obtiene el locale basado en el ID de idioma Inmovilla
     */
    public function getLocaleFromInmovillaId(): ?string
    {
        $mapping = self::getInmovillaLanguageMapping();
        return $mapping[$this->inmovilla_language_id] ?? null;
    }

    /**
     * Descripción truncada para previsualizaciones
     */
    public function getShortDescriptionAttribute(): string
    {
        if (empty($this->description)) {
            return '';
        }
        
        return strlen($this->description) > 150 
            ? substr($this->description, 0, 150) . '...'
            : $this->description;
    }

    /**
     * Verifica si tiene contenido
     */
    public function getHasContentAttribute(): bool
    {
        return !empty($this->title) || !empty($this->description);
    }

    // === MUTATORS ===
    
    /**
     * Auto-asigna locale basado en inmovilla_language_id
     */
    public function setInmovillaLanguageIdAttribute($value)
    {
        $this->attributes['inmovilla_language_id'] = $value;
        
        // Auto-asignar locale si no está definido
        if (empty($this->attributes['locale'])) {
            $mapping = self::getInmovillaLanguageMapping();
            $this->attributes['locale'] = $mapping[$value] ?? 'es';
        }
    }

    // === MÉTODOS ESTÁTICOS ===
    
    /**
     * Crea descripción desde datos de Inmovilla
     */
    public static function createFromInmovilla(int $propertyId, array $inmovillaData): ?self
    {
        $languageId = $inmovillaData['language_id'] ?? 1;
        $mapping = self::getInmovillaLanguageMapping();
        $locale = $mapping[$languageId] ?? 'es';
        
        return self::updateOrCreate(
            [
                'property_id' => $propertyId,
                'inmovilla_language_id' => $languageId,
            ],
            [
                'locale' => $locale,
                'title' => $inmovillaData['titulo'] ?? null,
                'description' => $inmovillaData['descrip'] ?? null,
            ]
        );
    }

    /**
     * Obtiene descripciones por idioma para una propiedad
     */
    public static function getByPropertyAndLocale(int $propertyId, string $locale): ?self
    {
        return self::where('property_id', $propertyId)
                   ->where('locale', $locale)
                   ->first();
    }

    /**
     * Obtiene todos los idiomas disponibles para una propiedad
     */
    public static function getAvailableLocalesForProperty(int $propertyId): array
    {
        return self::where('property_id', $propertyId)
                   ->whereNotNull('locale')
                   ->pluck('locale')
                   ->unique()
                   ->toArray();
    }

    // === VALIDACIÓN ===
    
    /**
     * Reglas de validación
     */
    public static function validationRules(): array
    {
        return [
            'property_id' => 'required|exists:properties,id',
            'inmovilla_language_id' => 'required|integer|min:1',
            'locale' => 'required|string|size:2',
            'title' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:10000',
        ];
    }

    // === EVENTOS DEL MODELO ===
    
    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($description) {
            // Auto-asignar locale si no está definido
            if (empty($description->locale) && !empty($description->inmovilla_language_id)) {
                $mapping = self::getInmovillaLanguageMapping();
                $description->locale = $mapping[$description->inmovilla_language_id] ?? 'es';
            }
        });
    }
}