<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'property_id', 
        'street', 
        'number', 
        'floor', 
        'door', 
        'postal_code', 
        'district', 
        'city', 
        'province', 
        'autonomous_community',
        
        // === CAMPOS INMOVILLA ===
        'inmovilla_direccion',
        'inmovilla_cp',
        'inmovilla_provincia',
    ];
    /*
    desestimamos los registros de ciudades provincias y comunidades autónomas


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
    */

    public function property()
    {
        return $this->belongsTo(Property::class);
    }

    // Relación con Ciudad
    public function city()
    {
        return $this->belongsTo(City::class);
    }
}
