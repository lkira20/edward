<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Inversion;

class InversionController extends Controller
{
    //
    public function index(Request $request)
  	{
  		$productos = Product::orderBy('id', 'desc')->get();

  		$inversiones = Inversion::orderBy('id', 'desc');;

  		if (isset($request->fecha_ini) && isset($request->fecha_fin)) {

    		$inversiones = $inversiones->whereDate('created_at', '>=', $request->fecha_ini)->whereDate('created_at', '<=', $request->fecha_fin);
    	}

    	$inversiones = $inversiones->paginate();

  		return view('inversion.index', ['productos' => $productos, 'inversiones' => $inversiones]);
  	}
}
