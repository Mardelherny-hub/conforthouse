<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OperationTranslation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['operation_id', 'name', 'locale'];

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }
}
