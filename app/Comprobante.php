<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comprobante extends Model
{
    // Campos de asignacion masiva
    protected $fillable = [
        'fecha', 'hora', 'tipo', 'total',
    ];

    // Relaciones de la tabla
    public function comprobantedetalles()
    {
        return $this->hasMany(ComprobanteDetalle::class);
    }
}