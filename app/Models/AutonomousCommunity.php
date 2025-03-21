<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AutonomousCommunity extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name', 'code'];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }
}
