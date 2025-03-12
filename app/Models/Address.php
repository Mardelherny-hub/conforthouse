<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'street', 'number', 'floor', 'door', 'postal_code', 'district', 'city_id'
    ];

    // Relación con Ciudad (Accedemos desde District)
    public function city()
    {
        return $this->belongsTo(City::class);
    }

    // Relación con Provincia (Accedemos desde Ciudad)
    public function province()
    {
        return $this->city() ? $this->city()->province() : null;
    }

    // Relación con Comuna (Si existe en tu estructura)
    public function commune()
    {
        return $this->city() ? $this->city()->commune() : null;
    }

    public function properties()
    {
        return $this->hasMany(Property::class);
    }
}
