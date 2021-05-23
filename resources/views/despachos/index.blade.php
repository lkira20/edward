@extends('layouts.app')

@section('content')

	<div class="card">
	  
	  <div class="card-body">
	    <h5 class="card-title">Stock</h5>

	    <div class="float-right m-3">
			<form class="form-inline" method="get" action="{{ route('despachos.index') }}">
			@csrf
			<input type="text" name="nombre" class="form-control" required>
			<button class="btn btn-primary">Filtrar</button>
			</form>
		</div>

	    <table class="table table-bordered table-sm table-hover table-striped">
	    	<thead>
	    		<tr>
	    			<th>Item</th>
	    			<th>Codigo</th>
	    			<th>Producto</th>
	    			<th>Precio s/.</th>
	    			<th>Ingreso</th>
	    			<th>Venta</th>
	    			<th>Deuda</th>
	    			<th>Stock</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		@forelse($codigos as $codigo)
	    		<tr>
	    			<td>{{$codigo->id}} </td>
	    			<td>{{$codigo->codigo}}</td>
	    			<td>{{$codigo->producto->name}}</td>
	    			<td>{{number_format($codigo->precio_unitario)}}</td>

	    			@php
	    				$deudas = 0;
	    				$ingresos = 0;
	    				$ventas = 0;

	    				foreach($codigo->estatus as $estatus){
	    					if($estatus->tipo == 'deuda'){
	    						$deudas += $estatus->cantidad;
	    					}

	    					if($estatus->tipo == 'venta'){
	    						$ventas += $estatus->cantidad;
	    					}

	    					if($estatus->tipo == 'ingreso'){
	    						//$ingresos += $codigo->cantidad;
	    						$ingresos += $estatus->cantidad;
	    					}
	    				}
	    			@endphp

	    			<td>{{$ingresos}}</td>
	    			<td>{{$ventas}}</td>
	    			<td>{{$deudas}}</td>
	    			<td>{{$codigo->cantidad}}</td>
	    		</tr>
	    		@empty
	    		@endforelse
	    	</tbody>
	    </table>

	    {{$codigos->render()}}
	  </div>
	</div>
@endsection
