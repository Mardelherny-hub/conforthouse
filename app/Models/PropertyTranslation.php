<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class PropertyTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
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
        'regime'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($translation) {
            $translation->slug = static::generateUniqueSlug($translation->title, $translation->locale);
        });
    }

    protected static function generateUniqueSlug($title, $locale)
    {
        $slug = Str::slug($title);
        $originalSlug = $slug;
        $counter = 1;

        // Validar que no exista ya ese slug para el mismo locale
        while (static::where('slug', $slug)->where('locale', $locale)->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
