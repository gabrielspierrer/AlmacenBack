<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rubro extends Model
{
    // Campos de asignacion masiva
    protected $fillable = [
        'nombre',
    ];

    // Relaciones de la tabla
    public function articulos()
    {
        return $this->hasMany(Articulo::class);
    }
}