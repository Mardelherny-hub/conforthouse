<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'code', 'autonomous_community_id'];

    public function autonomousCommunity()
    {
        return $this->belongsTo(AutonomousCommunity::class);
    }

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}
