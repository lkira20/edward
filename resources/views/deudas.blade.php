@extends('layouts.app')

@section('css')
<!-- Latest compiled and minified CSS -->
<style type="text/css">
	.search_select_box{
		max-width: 400px;
		margin: 80px auto;
	}

	.search_select_box select{
		width: 100%
	}
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
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
	    	<h5 class="card-title">Deudas</h5>
	    	<div class="float-right">
	    		<button class="btn btn-danger mb-2" data-toggle="modal" data-target="#nuevaDeuda">Nueva deuda</button>  
	    	</div>
	    	<table class="table table-bordered table-sm table-hover table-striped">
	    		<thead>
	    			<tr>
	    				<th>Item</th>
	    				<th>Cliente</th>
	    				<th>Producto</th>
	    				<th>Cantidad</th>
	    				<th>Total a pagar</th>
	    				<th>Precio unitario</th>
	    				<th>Accion</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			@forelse($deudas as $deuda)
	    			<tr>
	    				<td>{{$deuda->id}}</td>
	    				<td>{{$deuda->cliente != null? $deuda->cliente : '-'}}</td>
	    				<td>{{$deuda->producto->producto->name}}</td>
	    				<td>{{$deuda->cantidad}}</td>
	    				<td>{{$deuda->cantidad * $deuda->producto->precio_unitario}}</td>
	    				<td>{{$deuda->producto->precio_unitario}}</td>
	    				<td>
	    					<button class="btn btn-success" data-toggle="modal" data-target="#deudaModal{{$deuda->id}}">Saldar</button>

	    					<!-- Modal -->
							<div class="modal fade" id="deudaModal{{$deuda->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
							  <div class="modal-dialog">
							    <div class="modal-content">
							      <div class="modal-header">
							        <h5 class="modal-title" id="exampleModalLabel">Deuda</h5>
							        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
							          <span aria-hidden="true">&times;</span>
							        </button>
							      </div>
							      <form method="POST" action="{{ route('saldarDeuda') }}">
							      	@csrf
							      	@method('PUT')
							      <div class="modal-body">
							      	<input type="hidden" name="Estatu_id" value="{{$deuda->id}}">
							      	<input type="text" name="cantidad" class="form-control">
							      </div>
							      <div class="modal-footer">
							        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
							        <button type="submit" class="btn btn-primary">Guardar</button>
							      </div>
							      </form>
							    </div>
							  </div>
							</div>
	    				</td>
	    			</tr>
	    			@empty
	    			<tr>
	    				<p>No hay deudas registradas.</p>
	    			</tr>
	    			@endforelse
	    		</tbody>
	    	</table>

	    	{{$deudas->render()}}
	    	<!-- Modal Nueva deuda-->
		<div class="modal fade" id="nuevaDeuda" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Nueva deuda</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form method="post" action="{{ route('store_deuda') }}">
		      <div class="modal-body">
		      	@csrf
		      	<div class="row">
		 			<div class="col-6">
		 				<label>Código</label>
		 				<select class="form-control selectpicker" data-live-search="true" name="codigos_id" id="codigo_deuda" name="codigos_id" required>
				      		<option>Seleccione un código ya existente</option>
				      		@forelse($codigos2 as $codigo)
				      		<option value="{{$codigo->id}}">{{$codigo->codigo}}</option>	
				      		@empty
				      		@endforelse
				      	</select>
		 			</div>

		 			<div class="col-6">
		 				<label>Nombre</label>
		 				<input type="text" name="nombre" disabled class="form-control" name="name" id="name_deuda">
		 			</div>

		 			<div class="col-4">
		 				<label>Precio</label>
		 				<input type="text" name="precio" disabled class="form-control" name="precio" id="precio_deuda" required="">
		 			</div>

		 			<div class="col-4">
		 				<label>Cliente</label>
		 				<input type="text" name="cliente" class="form-control">
		 			</div>
		 			
					<div class="col-4">
						<label>Cantidad</label>
		 				<input type="text" name="cantidad" class="form-control" name="cantidad" id="cantidad_deuda" required>
		 			</div>		 			
		 		</div>
		 	   </div>
		      <div class="modal-footer">
		        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
		        <button type="submit" class="btn btn-primary">Guardar</button>
		      	</div>
		      </form>
		    </div>
		  </div>
		</div>
	  	</div>
	</div>

@endsection

@section('js')

<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

<script type="text/javascript">
	$(document).ready( function () {

		$('.selectpicker').selectpicker();

		$('#codigo_deuda').on('change', function(){
			$.ajax({
            url: '/api/consultarNombre/'+$('#codigo_deuda').val(),
            dataType: 'json',
            cache: false,
            success: function (data) {
             
            	console.log(data);
            	$('#name_deuda').val(data.producto.name);
            	$('#precio_deuda').val(data.precio_unitario);
            },
            error: function (data) {
            	console.log(data);
            }
          })
		});
		
	});
</script>

@endsection
