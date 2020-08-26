<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Piso_venta;
use App\Despacho;
use Illuminate\Support\Facades\Auth;
use App\Inventario;
use App\Inventario_piso_venta;
//use App\Inventory;

class DespachosController extends Controller
{
    //
    public function index()
    {

    	return view('despachos.index');
    }

    public function get_despachos()
    {
        $usuario = Auth::user()->piso_venta->id;

        $despachos = Despacho::with(['productos' => function($producto){
            $producto->select('product_name');
        }])->where('piso_venta_id', $usuario)->orderBy('id', 'desc')->paginate(1);

        return response()->json($despachos);
    }

    public function confirmar_despacho(Request $request)
    {
        $usuario = Auth::user()->piso_venta->id;

        $despacho = Despacho::with(['productos' => function($producto){
            $producto->select('product_name');
        }])->findOrFail($request->id);
        $despacho->confirmado = 1;
        $despacho->save();

        
        foreach ($despacho->productos as $valor) {
            //BUSCAMOS EL ID EN INVENTARIO
            $producto = Inventario::select('id')->where('inventory_id', $valor->pivot->inventory_id)->orderBy('id', 'desc')->first();

            $inventario = Inventario_piso_venta::with('inventario')->where('piso_venta_id', $usuario)->where('inventario_id', $producto->id)->orderBy('id', 'desc')->first(); 
            //SI ES UN DESPACHO O ES UN RETIRO
            if($despacho->type == 1){
                if ($valor->pivot->tipo == 1) {//SI ES AL MENOR DESCONTAR DE CANTIDAD AL MENOR

                    $inventario->cantidad_menor += $valor->pivot->cantidad;
                    $inventario->cantidad_mayor = $Inventario->cantidad_menor / $inventario->inventario->qty_per_unit; 
                }else{
                    $inventario->cantidad_mayor += $valor->pivot->cantidad;
                }
            }else{
                if ($valor->pivot->tipo == 1) {//SI ES AL MENOR DESCONTAR DE CANTIDAD AL MENOR

                    $inventario->cantidad_menor -= $valor->pivot->cantidad;
                    $inventario->cantidad_mayor = $Inventario->cantidad_menor / $inventario->inventario->qty_per_unit; 
                }else{
                    $inventario->cantidad_mayor -= $valor->pivot->cantidad;
                }
            }
            $inventario->save();

    
        }
        
        return response()->json($despacho);
    }

    public function negar_despacho(Request $request)
    {

        $despacho = Despacho::with(['productos' => function($articulo){
            $articulo->select('product_name');
        }])->findOrFail($request->id);
        $despacho->confirmado = 0;
        $despacho->save();

        foreach ($despacho->productos as $valor) {
            
            $producto = Inventario_piso_venta::whereHas('inventario', function($q){
                    $q->where('inventory_id', $valor->pivot->inventory_id);
                })->orderBy('id', 'desc')->first();


            /*
            if ($valor->pivot->tipo == 1) {//SI ES AL MENOR DESCONTAR DE CANTIDAD AL MENOR

                $producto->cantidad_menor += $valor->pivot->cantidad;
            }else{
                $producto->cantidad_mayor += $valor->pivot->cantidad;
            }

            $producto->save();*/
        }

        return response()->json($producto);
    }

    public function ultimo_despacho()
    {
        $usuario = Auth::user()->piso_venta->id;

        $despacho = Despacho::select('id_extra')->where('piso_venta_id', $usuario)->orderBy('id', 'desc')->first();

        return response()->json($despacho);
    }

    public function get_despachos_web(Request $request)//DEL LADO DE LA WEB
    {
        $despachos = Despacho::where('piso_venta_id', $request->piso_venta_id)->where('id_extra', '>', $request->ultimo_despacho)->get();

        return response()->json($despachos);
    }

    public function registrar_despacho_piso_venta (Request $request)
    {
        
      
            foreach ($request->despachos as $despacho){
                $registro = new Despacho();
                $registro->id_extra = $despacho['id_extra'];
                $registro->piso_venta_id = $despacho['piso_venta_id'];
                $registro->type = $despacho['type'];
                $registro->save();
            }
        
        

        return response()->json(true);
    }

    public function get_despachos_sin_confirmacion($id)//DEL LADO DE LA WEB
    {
        $despachos = Despacho::select('id_extra')->where('piso_venta_id', $id)->where('confirmado', null)->get();

        return response()->json($despachos);
    }

    public function get_despachos_confirmados(Request $request)//RECIBE EL RESULTADO DEL METODO ANTERIOR
    {
        $despachos = [];

        foreach ($request->despachos as $valor) {
        
            $despachos[] = Despacho::where('id_extra', $valor['id_extra'])->first();
        }
    

        return response()->json($despachos);
    }

    public function actualizar_confirmaciones(Request $request)//DEL LADO DE LA WEB
    {
        foreach ($request->despachos as $valor) {
            
            $despacho = Despacho::where('id_extra', $valor['id_extra'])->first();
            $despacho->confirmado = $valor['confirmado'];
            $despacho->save();
        }

        return response()->json("actualizado con exito");
    }

    public function index_almacen()
    {

    	return view('despachos.index_almacen');
    }

    public function create()
    {
    	$pisos_venta = Piso_venta::all();

    	//$productos = Inventory::where('status', 2)->get();
    	
    }

    public function store(Request $request)
    {
    	
    }
}
