<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'image_path',
        'thumbnail_path',
        'order',
        'is_featured',
        'all_text',
        // === CAMPOS INMOVILLA ===
        'inmovilla_photo_id',
        'is_before_after',
        'inmovilla_url',
    ];

    protected $casts = [
        'is_featured' => 'boolean',
        'is_before_after' => 'boolean',
    ];
    
    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
