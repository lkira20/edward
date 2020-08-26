<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UsersController extends Controller
{
    //
    public function get_id()//ID PISO DE VENTA
    {

    	$usuario = Auth::user()->piso_venta->id;

    	return response()->json($usuario);
    }
}
