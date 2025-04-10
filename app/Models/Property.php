<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'orientation', // corregido
        'exterior_type', // corregido
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
        'description'
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

        // Verificamos si el slug ya existe en la tabla properties
        while (static::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

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

    // Métodos para acceder a ciudad, provincia y comuna sin depender de distrito
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
}
