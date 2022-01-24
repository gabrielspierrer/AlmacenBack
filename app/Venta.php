<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    protected $fillable = [
        'articulo_id', 'cantidad', 'precio',
    ];

    public function articulo()
    {
        return $this->belongsTo(Articulo::class);
    }
}