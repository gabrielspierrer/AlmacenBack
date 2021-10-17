<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Articulo extends Model
{
    protected $fillable = [
        'nombre', 'rubro_id', 'stock_min', 'stock_max', 'precio', 'fecha_venc',
    ];

    public function rubro()
    {
        return $this->belongsTo(Rubro::class);
    }

    public function ventacompras()
    {
        return $this->hasMany(VentaCompra::class);
    }
}
