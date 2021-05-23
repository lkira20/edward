<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inversion extends Model
{
    //
    public function codigos()
    {
        return $this->hasMany('App\Codigos');
    }
}
