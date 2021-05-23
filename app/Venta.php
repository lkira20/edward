<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Venta extends Model
{
    //
    protected $fillable = [
    ];

    public function detalle()
    {
        return $this->belongsToMany('App\Codigos', 'detalle_ventas')->using('App\Detalle_venta')->withPivot([
                            'cantidad',
                            'total'
                        ]);
    }
}
