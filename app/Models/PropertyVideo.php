<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyVideo extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'video_url',
        'youtube_code',
        'title',
        'order',
        'is_inmovilla',
    ];

    protected $casts = [
        'is_inmovilla' => 'boolean',
        'order' => 'integer',
    ];

    // === RELACIONES ===
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // === SCOPES ===
    
    public function scopeInmovilla($query)
    {
        return $query->where('is_inmovilla', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    // === ACCESSORS ===
    
    /**
     * Obtiene la URL del video embebido
     */
    public function getEmbedUrlAttribute()
    {
        if ($this->youtube_code) {
            return "https://www.youtube.com/embed/{$this->youtube_code}";
        }
        
        if ($this->video_url) {
            // Convertir URLs de YouTube normales a embed
            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->video_url, $matches)) {
                return "https://www.youtube.com/embed/{$matches[1]}";
            }
            
            // Para otros proveedores se puede expandir aquí
            return $this->video_url;
        }
        
        return null;
    }

    /**
     * Obtiene la imagen thumbnail del video
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->youtube_code) {
            return "https://img.youtube.com/vi/{$this->youtube_code}/hqdefault.jpg";
        }
        
        if ($this->video_url && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $this->video_url, $matches)) {
            return "https://img.youtube.com/vi/{$matches[1]}/hqdefault.jpg";
        }
        
        return null;
    }

    /**
     * Verifica si es un video de YouTube
     */
    public function getIsYoutubeAttribute()
    {
        return !empty($this->youtube_code) || 
               (strpos($this->video_url, 'youtube.com') !== false || strpos($this->video_url, 'youtu.be') !== false);
    }

    // === MUTATORS ===
    
    /**
     * Auto-extrae código de YouTube de URLs
     */
    public function setVideoUrlAttribute($value)
    {
        $this->attributes['video_url'] = $value;
        
        // Auto-extraer código de YouTube si es una URL de YouTube
        if ($value && preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([a-zA-Z0-9_-]+)/', $value, $matches)) {
            $this->attributes['youtube_code'] = $matches[1];
        }
    }

    // === MÉTODOS HELPER ===
    
    /**
     * Obtiene el proveedor del video
     */
    public function getProvider(): string
    {
        if ($this->getIsYoutubeAttribute()) {
            return 'youtube';
        }
        
        if (strpos($this->video_url, 'vimeo.com') !== false) {
            return 'vimeo';
        }
        
        return 'other';
    }

    /**
     * Verifica si el video es válido
     */
    public function isValid(): bool
    {
        return !empty($this->video_url) || !empty($this->youtube_code);
    }
}