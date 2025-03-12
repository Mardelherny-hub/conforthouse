<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['name'];

    public function properties()
    {
        return $this->hasMany(Property::class);
    }

    public function translations()
    {
        return $this->hasMany(OperationTranslation::class);
    }

}
