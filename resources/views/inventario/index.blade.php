@extends('layouts.app')

@section('css')

@endsection

@section('content')
	
	@if( Session::has('message') )
	<div class="alert alert-success alert-dismissible fade show" role="alert">
	  {{ Session::get('message') }}
	  <button type="button" class="close" data-dismiss="alert" aria-label="Close">
	    <span aria-hidden="true">&times;</span>
	  </button>
	</div>
	@endif

	<div class="card">
	  
	  <div class="card-body">
	    <h5 class="card-title">Inventario</h5>

	    <table class="table table-bordered table-sm table-hover table-striped">
	    	<thead>
	    		<tr>
	    			<th>Item</th>
	    			<th>Fecha actual</th>
	    			<th>Fecha pago</th>
	    			<th>Estatus de credito</th>
	    			<th>Tipo</th>
	    			<th>Codigo</th>
	    			<th>Cantidad</th>
	    			<th>Producto</th>
	    			<th>Precio Bs/.</th>
	    			<th>Porcentaje %</th>
	    			<th>Total Bs/.</th>
	    			<th>cliente</th>
	    			<th>Autorizado por</th>
	    			<th>Acción</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		@forelse($estados as $estado)
	    		<tr>
	    			
	    			<td>{{$estado->id}}</td>
	    			<td>{{$estado->created_at}}</td>
	    			<td></td>
	    			<td></td>
	    			<td>{{$estado->tipo}}</td>
	    			<td>{{$estado->producto->codigo}}</td>
	    			<td>{{$estado->cantidad}}</td>
	    			<td>{{$estado->producto->producto->name}}</td>
	    			<td>{{number_format($estado->producto->precio)}}</td>
	    			<td>{{$estado->producto->porcentaje}}</td>
	    			<td>{{number_format($estado->producto->precio_unitario)}}</td>
	    			<td>{{$estado->cliente != null? $estado->cliente : ''}}</td>
	    			<td></td>
	    			<td>
	    				<button class="btn btn-primary" data-toggle="modal" data-target="#editarModalmas{{$estado->id}}">ma</button>
	    				<button class="btn btn-warning" data-toggle="modal" data-target="#editarModalmenos{{$estado->id}}">me</button>
	    				{{--<button class="btn btn-warning" data-toggle="modal" data-target="#editarModal{{$estado->id}}">Editar</button>--}}
	    				<form method="post" action="{{ route('deleteEstado', $estado->id) }}">
	    					@csrf
	    					@method('DELETE')
	    					<button class="btn btn-danger" type="submit">Eli</button>
	    				</form>
	    			</td>

	    			<!-- Modal editar-->
					<div class="modal fade" id="editarModalmas{{$estado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Sumar</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <form method="post" action="{{ route('updateEstado') }}">
					      @method('PUT')
					      @csrf
					      <div class="modal-body">
					      	<input type="hidden" name="estatus_id" value="{{$estado->id}}">
					      	<input type="hidden" name="operacion" value="mas">
					      	<label>Cantidad:</label>
					      	<input type="text" name="cantidad" class="form-control" placeholder="cantidad">
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Editar</button>
					        <button type="submit" class="btn btn-primary">Editar</button>
					      </div>
					      </form>
					    </div>
					  </div>
					</div>

					<!-- Modal menos-->
					<div class="modal fade" id="editarModalmenos{{$estado->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog">
					    <div class="modal-content">
					      <div class="modal-header">
					        <h5 class="modal-title" id="exampleModalLabel">Menos</h5>
					        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
					          <span aria-hidden="true">&times;</span>
					        </button>
					      </div>
					      <form method="post" action="{{ route('updateEstado') }}">
					      @method('PUT')
					      @csrf
					      <div class="modal-body">
					      	<input type="hidden" name="estatus_id" value="{{$estado->id}}">
					      	<input type="hidden" name="operacion" value="menos">
					      	<label>Cantidad:</label>
					      	<input type="text" name="cantidad" class="form-control" placeholder="cantidad">
					      </div>
					      <div class="modal-footer">
					        <button type="button" class="btn btn-secondary" data-dismiss="modal">Editar</button>
					        <button type="submit" class="btn btn-primary">Editar</button>
					      </div>
					      </form>
					    </div>
					  </div>
					</div>
	    		</tr>
	    		@empty
	    		@endforelse
	    	</tbody>
	    </table>

	    {{$estados->render()}}
	  </div>
	</div>

@endsection

@section('js')
	<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

@endsection