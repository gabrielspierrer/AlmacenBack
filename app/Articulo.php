<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable = [
        'nombre', 'rubro_id', 'stock', 'precio',
    ];

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