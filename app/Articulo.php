<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    // Campos de asignacion masiva
    protected $fillable = [
        'nombre', 'rubro_id', 'stock', 'precio_costo', 'precio_venta',
    ];

    // Relaciones de la tabla
    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function comprobantedetalles()
    {
        return $this->hasMany(ComprobanteDetalle::class);
    }

    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    public function compras()
    {
        return $this->hasMany(Compra::class);
    }
}