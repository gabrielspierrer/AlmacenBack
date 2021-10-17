<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ComprobanteDetalle extends Model
{
    protected $fillable = [
        'comprobante_id', 'articulo', 'cantidad', 'precio',
    ];

    public function comprobante()
    {
        return $this->belongsTo(Comprobante::class);
    }
}
