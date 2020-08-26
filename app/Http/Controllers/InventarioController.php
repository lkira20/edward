<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Inventario;
use App\Inventario_piso_venta;
use App\Piso_venta;
use App\Venta;
use App\Detalle_venta;
use App\Despacho;
use Illuminate\Support\Facades\Auth;
use App\Inventory;
use App\Despacho_detalle;

class InventarioController extends Controller
{
    //
    public function index()
    {

    	return view('inventario.index');
    }

    public function get_inventario()
    {
        $usuario = Auth::user()->piso_venta->id;

        //$inventario = Inventario_piso_venta::with(['inventario' => function($inventario){
        //    $inventario->where('name', 'quo');
        //}])->where('piso_venta_id', $usuario)->whereHas('inventario')->get();

        $inventario  = Inventario_piso_venta::with('inventario.precio')->where('piso_venta_id', $usuario)->whereHas('inventario', function($q){
           // $q->where('name', 'quo');
        })->paginate(1);
        return response()->json($inventario);
    }

    public function prueba()
    {

        $inventario = Inventario::with('inventory')->get();
    	
    	return $inventario;
    }
}
