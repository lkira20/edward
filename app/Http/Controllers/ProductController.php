<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Product;
use App\Codigos;
use App\Estatu;
use App\Inversion;

class ProductController extends Controller
{
    //
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function store(Request $request)
    {

    	$product = new Product();
    	$product->name = $request->name;
    	$product->save();

    	return back()->with('message', 'producto registrado exitosamente');
    }

    public function store_codigo(Request $request)
    {

        $productos = json_decode($request->json);
        
        $invertirTotal = 0;
        $gananciaTotal = 0;
        
        foreach ($productos as $producto) {
            
            $invertirTotal+= $producto->pagar;
            $gananciaTotal+= $producto->ganancia;
        }

        $inversion = new Inversion();
        $inversion->monto_invertir = $invertirTotal;
        $inversion->ganancia = $gananciaTotal;
        $inversion->save();

        foreach ($productos as $producto) {
        
        	$codigo = new Codigos();
            $codigo->inversion_id = $inversion->id;
        	$codigo->products_id = $producto->id;
        	$codigo->precio = $producto->precio;
        	$codigo->cantidad = $producto->cantidad;
            $codigo->ganancia = $producto->ganancia;
        	$codigo->total = $producto->pagar;
        	$codigo->codigo = $producto->codigo;
            $codigo->porcentaje = $producto->porcentaje;
            $codigo->precio_unitario = $producto->precio_unitario;

        	if (isset($producto->estatus)) {
        		$codigo->estatus_credito = $producto->estatus;
        	}
        	//$codigo->autorizado = $request->autorizado;
        	$codigo->save();

            $estado = new Estatu();
            $estado->tipo = 'ingreso';
            $estado->cantidad = $producto->cantidad;
            $estado->codigos_id = $codigo->id;
            $estado->save();

        }

    	return back()->with('message', 'codigo registrado exitosamente');
    }

    public function consultarNombre($id)
    {
        $codigo = Codigos::with('producto')->findOrFail($id);

        return response()->json($codigo);
    }
}
