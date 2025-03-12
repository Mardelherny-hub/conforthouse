<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PropertyTypeTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['property_type_id', 'name', 'locale'];

    public function propertyType()
    {
        return $this->belongsTo(PropertyType::class);
    }

}
