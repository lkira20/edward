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
	    <h5 class="card-title">Data</h5>

	    <div class="float-right">
	    	<button class="btn btn-primary mb-2" data-toggle="modal" data-target="#nuevoProducto">Nuevo Producto</button>
		    <button class="btn btn-secondary mb-2" data-toggle="modal" data-target="#nuevoCodigo">Nuevo Codigo</button> 
		    {{--<button class="btn btn-danger mb-2" data-toggle="modal" data-target="#nuevaDeuda">Nuevo deuda</button>--}}     
		</div> 

	    <!-- Modal Nuevo Producto-->
		<div class="modal fade" id="nuevoProducto" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Nuevo producto</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form method="post" action="{{ route('store.product') }}">
		      <div class="modal-body">
		 		@csrf
		 		<div class="row m-3">
		 			<label>Nombre:</label>
		      		<input type="text" name="name" class="form-control">
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

		<!-- Modal Nuevo codigo-->
		<div class="modal fade" id="nuevoCodigo" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Nuevo codigo</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form method="post" action="{{ route('store.codigo') }}">
		      <div class="modal-body">
		      	@csrf
		      	<div class="row">
		 			<div class="col">
		 				{{--
		 				<div class="search_select_box">
		 					<select data-live-search="true">
		 						<option>Web Design</option>
		 						<option>web Development</option>
		 						<option>App Development</option>
		 						<option>Digital Marketing</option>
		 						<option>Seo</option>
		 						<option>Social Media Marketing</option>
		 					</select>
		 				</div>
		 				--}}
		 				<select class="form-control selectpicker" name="products_id" required data-live-search="true">
				      		<option value="">Seleccione un producto ya existente</option>
				      		@foreach($productos as $producto)
				      			<option value="{{$producto->id}}">{{$producto->name}}</option>

				      		@endforeach
				      	</select>
		 			</div>
		 		</div>

		 		<div class="row mt-2">
		 			<div class="col">
		 				<label>Precio:</label>
		 	
		 				<input type="text" name="precio" class="form-control" id="precio" required>
		 			</div>

		 			<div class="col">
		 				<label>Cantidad:</label>
		 				<input type="text" name="cantidad" class="form-control" id="cantidad" required>
		 			</div>

		 			<div class="col">
		 				<label>Porcentaje: %</label>
		 				<input type="text" name="porcentaje" class="form-control" id="porcentaje" required>
		 			</div>

		 			<div class="col">
		 				<label>Total:</label>
		 				<input type="text" name="total"  class="form-control" id="total" readonly>
		 			</div>
		 		</div>

		 		<div class="row mt-2">
		 			<div class="col">
		 				<label>Código:</label>
		 				<input type="text" name="codigo" class="form-control" required>
		 			</div>

		 			<div class="col">
		 				<label>estatus de credito:</label>
		 				<input type="text" name="estatus_credito" class="form-control">
		 			</div>
		 			
		 			<input type="hidden" name="precio_unitario" id="precio_unitario">
		 			<input type="hidden" name="ganancia" id="ganancia">
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

		<!-- Modal Nuevo ingreso-->
		<div class="modal fade" id="nuevoIngreso" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Nuevo ingreso</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form method="post" action="{{ route('store_ingreso') }}">
		      @csrf
		      <div class="modal-body">

		      	<div class="row">
		 			<div class="col-6">
		 				<label>Código</label>
		 				<select class="form-control selectpicker" id="codigo_ingreso" name="codigos_id" required data-live-search="true">
				      		<option>Seleccione un código ya existente</option>
				      		@forelse($codigos2 as $codigo)
				      		<option value="{{$codigo->id}}">{{$codigo->codigo}}</option>	
				      		@empty
				      		@endforelse
				      	</select>
		 			</div>

		 			<div class="col-6">
		 				<label>Nombre</label>
		 				<input type="text" name="nombre" disabled class="form-control" id="name_ingreso">
		 			</div>

		 			<div class="col-6">
		 				<label>Precio</label>
		 				<input type="text" name="precio" disabled class="form-control" id="precio_ingreso">
		 			</div>

					<div class="col-6">
						<label>Cantidad</label>
		 				<input type="text" name="cantidad" class="form-control" name="cantidad" required>
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

		<!-- Modal Nueva venta-->
		<div class="modal fade" id="nuevaVenta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
		  <div class="modal-dialog modal-lg">
		    <div class="modal-content">
		      <div class="modal-header">
		        <h5 class="modal-title" id="exampleModalLabel">Nueva venta</h5>
		        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
		      </div>
		      <form method="post" action="{{ route('store_venta') }}">
		      <div class="modal-body">
		      	@csrf
		      	<div class="row">
		 			<div class="col-6">
		 				<label>Código</label>
		 				<select class="form-control selectpicker" name="codigos_id" id="codigo_venta" name="codigos_id" required data-live-search="true">
				      		<option>Seleccione un código ya existente</option>
				      		@forelse($codigos2 as $codigo)
				      		<option value="{{$codigo->id}}">{{$codigo->codigo}}</option>	
				      		@empty
				      		@endforelse

				      	</select>
		 			</div>

		 			<div class="col-6">
		 				<label>Nombre</label>
		 				<input type="text" name="nombre" disabled class="form-control" name="name" id="name_venta">
		 			</div>

		 			<div class="col-6">
		 				<label>Precio</label>
		 				<input type="text" name="precio" disabled class="form-control" name="precio" id="precio_venta">
		 			</div>

					<div class="col-6">
						<label>Cantidad</label>
		 				<input type="text" name="cantidad" class="form-control" name="cantidad" id="cantidad_venta" required>
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

		<!-- Modal Nueva deuda-->
		{{--
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
		 				<select class="form-control" name="codigos_id" id="codigo_deuda" name="codigos_id" required>
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
		--}}
	    <table class="table table-bordered table-sm table-hover table-striped">
	    	<thead>
	    		<tr>
	    			<th>Item</th>
	    			<th>Código</th>
	    			<th>Producto</th>
	    			<th>Precio</th>
	    		</tr>
	    	</thead>
	    	<tbody>
	    		@forelse($codigos as $codigo)
	    		<tr>
	    			<td>{{$codigo->id}}</td>
	    			<td>{{$codigo->codigo}}</td>
	    			<td>{{$codigo->producto->name}}</td>
	    			<td>{{number_format($codigo->precio_unitario)}}</td>
	    		</tr>
	    		@empty
	    		@endforelse
	    	</tbody>
	    </table>

	    {{$codigos->render()}}
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
		//$('.search_select_box').selectpicker();

		$('#precio').on('keyup', function(e){
			let porcentaje = ($('#precio').val() * $('#porcentaje').val()) /100;
			$('#ganancia').val(porcentaje);
			console.log(parseInt($('#precio').val()));
			let total = (parseInt($('#precio').val()) + porcentaje) * $('#cantidad').val()
			$('#total').val(total);
			$('#precio_unitario').val((parseInt($('#precio').val()) + porcentaje));
		});

		$('#cantidad').on('keyup', function(e){
			let porcentaje = ($('#precio').val() * $('#porcentaje').val()) /100;
			$('#ganancia').val(porcentaje);
			console.log(parseInt($('#precio').val()));
			let total = (parseInt($('#precio').val()) + porcentaje) * $('#cantidad').val()
			$('#total').val(total);
			$('#precio_unitario').val((parseInt($('#precio').val()) + porcentaje));
		});

		$('#porcentaje').on('keyup', function(e){
			let porcentaje = ($('#precio').val() * $('#porcentaje').val()) /100;
			$('#ganancia').val(porcentaje);
			console.log(parseInt($('#precio').val()));
			let total = (parseInt($('#precio').val()) + porcentaje) * $('#cantidad').val()
			$('#total').val(total);
			$('#precio_unitario').val((parseInt($('#precio').val()) + porcentaje));
		});
		
		$('#codigo_ingreso').on('change', function(){
			$.ajax({
            url: '/api/consultarNombre/'+$('#codigo_ingreso').val(),
            dataType: 'json',
            cache: false,
            success: function (data) {
             
            	console.log(data);
            	$('#name_ingreso').val(data.producto.name);
            	$('#precio_ingreso').val(data.total);
            },
            error: function (data) {
            	console.log(data);
            }
          })
		});

		$('#codigo_venta').on('change', function(){
			$.ajax({
            url: '/api/consultarNombre/'+$('#codigo_venta').val(),
            dataType: 'json',
            cache: false,
            success: function (data) {
             
            	console.log(data);
            	$('#name_venta').val(data.producto.name);
            	$('#precio_venta').val(data.precio_unitario);
            },
            error: function (data) {
            	console.log(data);
            }
          })
		});

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
