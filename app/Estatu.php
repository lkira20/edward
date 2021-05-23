<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Estatu extends Model
{
    //
    public function producto()
    {
        return $this->belongsTo('App\Codigos', 'codigos_id');
    }
}
