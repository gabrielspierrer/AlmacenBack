<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    // Campos de asignacion masiva
    protected $fillable = [
        'articulo_id', 'cantidad', 'precio',
    ];

    // Relaciones de la tabla
    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}