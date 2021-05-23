<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Codigos extends Model
{
    //
    public function producto()
    {
        return $this->belongsTo('App\Product', 'products_id');
    }

    public function estatus()
    {
        return $this->hasMany('App\Estatu');
    }
}
