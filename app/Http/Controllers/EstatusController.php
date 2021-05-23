<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Estatu;
use App\Codigos;

class EstatusController extends Controller
{
    //
    public function store_ingreso(Request $request)
    {
    	$estado = new Estatu();
    	$estado->tipo = 'ingreso';
    	$estado->cantidad = $request->cantidad;
    	$estado->codigos_id = $request->codigos_id;
    	$estado->save();

        $codigo = Codigos::findOrFail($request->codigos_id);
        $codigo->cantidad += $request->cantidad;
        $codigo->save();

        return back()->with('message', 'ingreso registrado exitosamente');
    }

    public function store_venta(Request $request)
    {
    	$estado = new Estatu();
    	$estado->tipo = 'venta';
    	$estado->cantidad = $request->cantidad;
    	$estado->codigos_id = $request->codigos_id;
    	$estado->save();

        $codigo = Codigos::findOrFail($request->codigos_id);
        $codigo->cantidad -= $request->cantidad;
        $codigo->save();

        return back()->with('message', 'venta registrada exitosamente');
    }

    public function store_deuda(Request $request)
    {
    	$estado = new Estatu();
    	$estado->tipo = 'deuda';
    	$estado->cantidad = $request->cantidad;
    	$estado->codigos_id = $request->codigos_id;
        if (isset($request->cliente)) {
            $estado->cliente = $request->cliente;
        }
    	$estado->save();

        $codigo = Codigos::findOrFail($request->codigos_id);
        $codigo->cantidad -= $request->cantidad;
        $codigo->save();

        return back()->with('message', 'deuda registrada exitosamente');
    }

    public function lista_de_deudas()
    {
        $deudas = Estatu::orderBy('id', 'desc')->where('tipo' ,'deuda')->paginate();

        //selector
        $codigos2 = Codigos::orderBy('id', 'desc')->get();

        return view('deudas', ['deudas' => $deudas,'codigos2' => $codigos2]);
    }

    public function saldarDeuda(Request $request)
    {
        $estado = Estatu::findOrFail($request->Estatu_id);
        $estado->cantidad -= $request->cantidad;
        $estado->save();

        $estado2 = new Estatu();
        $estado2->tipo = 'venta';
        $estado2->cantidad = $request->cantidad;
        $estado2->codigos_id = $estado->codigos_id;
        $estado2->save();

        return back()->with('message', 'deuda saldada exitosamente');
    }

    public function updateEstado(Request $request)
    {
        $estado = Estatu::findOrFail($request->estatus_id);

        if ($estado->tipo == "ingreso") {
            if ($request->operacion == "mas") {
            
            $estado->cantidad += $request->cantidad;
            $estado->save();

            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad += $request->cantidad;
            $codigo->save();

            }else if($request->operacion == "menos"){

            $estado->cantidad -= $request->cantidad;
            $estado->save();

            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad -= $request->cantidad;
            $codigo->save();

            }

        }

        if ($estado->tipo == "venta") {
            if ($request->operacion == "mas") {
            
            $estado->cantidad += $request->cantidad;
            $estado->save();

            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad -= $request->cantidad;
            $codigo->save();

            }else if($request->operacion == "menos"){

            $estado->cantidad -= $request->cantidad;
            $estado->save();

            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad += $request->cantidad;
            $codigo->save();

            }

        }

        if ($estado->tipo == "deuda") {
            if ($request->operacion == "mas") {
            
            $estado->cantidad += $request->cantidad;
            $estado->save();

            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad -= $request->cantidad;
            $codigo->save();

            }else if($request->operacion == "menos"){

            $estado->cantidad -= $request->cantidad;
            $estado->save();

            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad += $request->cantidad;
            $codigo->save();

            }

        }

        return back()->with('message', 'registro editado exitosamente');
    }

    public function destroy($id)
    {
        $estado = Estatu::findOrFail($id);

        if ($estado->tipo == "ingreso") {

            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad -= $estado->cantidad;
            $codigo->save();

        }

        if ($estado->tipo == "venta") {
          
            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad += $estado->cantidad;
            $codigo->save();
        }

        if ($estado->tipo == "deuda") {
            $codigo = Codigos::findOrFail($estado->codigos_id);
            $codigo->cantidad += $estado->cantidad;
            $codigo->save();   

        }

        $estado->delete();

        return back()->with('message', 'registro eliminado exitosamente');
    }
}
