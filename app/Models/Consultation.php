<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Consultation extends Model
{
    protected $fillable = [
        'nombre',
        'email',
        'telefono',
        'asunto',
        'tipo_consulta',
        'interested_in',
        'mensaje',
        'origen',
        'locale',
        'ip_address',
        'user_agent',
        'estado',
        'fecha_respuesta',
        'respuesta_admin',
    ];

    protected $casts = [
        'fecha_respuesta' => 'datetime',
    ];
}