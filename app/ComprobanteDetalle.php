<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprobanteDetalle extends Model
{
    // Campos de asignacion masiva
    protected $fillable = [
        'comprobante_id', 'articulo_id', 'cantidad', 'precio_unitario', 'importe',
    ];

    // Relaciones de la tabla
    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}