<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    protected $fillable = [
        'fecha', 'hora', 'tipo', 'total',
    ];

    public function comprobantedetalles()
    {
        return $this->hasMany(ComprobanteDetalle::class);
    }
}