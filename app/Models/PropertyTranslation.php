<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyTranslation extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id',
        'locale',
        'title',
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

    public function property()
    {
        return $this->belongsTo(Property::class);
    }
}
