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

	<div class="float-right m-3">
		<form class="form-inline" method="get" action="{{ route('ventas.index') }}">
		@csrf
		<input type="date" name="fecha_ini" class="form-control" required>
		<input type="date" name="fecha_fin" class="form-control" required>
		<button class="btn btn-primary">Filtrar</button>
		</form>
	</div>

	<div class="float-right m-3">
		<button class="btn btn-success" data-toggle="modal" data-target="#exampleModal">Nueva venta</button>
	</div>

	<!-- Modal -->
	<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	    <div class="modal-content">
	      <div class="modal-header">
	        <h5 class="modal-title" id="exampleModalLabel">Nueva venta</h5>
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	          <span aria-hidden="true">&times;</span>
	        </button>
	      </div>
	      <form method="post" action="{{ route('venta.store') }}">
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
		 				<select class="form-control selectpicker" name="products_id" data-live-search="true" id="producto_id">
				      		<option value="">Seleccione un producto ya existente</option>
				      		@foreach($productos as $producto)
				      			<option nombre="{{$producto->producto->name}}" value="{{$producto->id}}" precio="{{$producto->precio_unitario}}" porcentaje="{{$producto->porcentaje}}" precio_compra="{{$producto->precio}}">{{$producto->producto->name}}</option>

				      		@endforeach
				      	</select>
				      	<input type="hidden" name="product_name" id="product_name">
		 			</div>
		 		</div>

		 		<div class="row mt-2">
		 			
		 				<input type="hidden" name="precio" class="form-control" id="precio">

		 			<div class="col">
		 				<label>Cantidad:</label>
		 				<input type="text" name="cantidad" class="form-control" id="cantidad">
		 			</div>

		 			<div class="col">
		 				<label>Pagar</label>
		 				<input type="text" name="pagar" class="form-control" id="pagar" readonly>

		 			</div>

		 			<div>
		 				<label>ganancia</label>
		 				<input type="text" name="ganancia"  class="form-control" id="ganancia" readonly>
		 			</div>

		 			<input type="hidden" name="total"  class="form-control" id="total" readonly>
		 			<input type="hidden" name="precio_compra"  class="form-control" id="precio_compra">

		 			<input type="hidden" name="porcentaje"  class="form-control" id="porcentaje">
		 			
		 		</div>

		 		<div class="float-right m-3">
		 			<button class="btn btn-primary" type="button" id="agregar">Agregar</button>
		 		</div>

		 		<table class="table table-bordered table-sm table-hover table-striped">
			    	<thead>
			    		<tr>
			    			<th>Item</th>
			    			<th>Producto </th>
			    			<th>Precio</th>
			    			<th>Cantidad</th>
			    			<th>Ganancia</th>
			    			<th>Pagar</th>
			    			<th>Acci??n</th>
			    		</tr>
			    	</thead>
			    	<tbody id="bodyTable">
			    		
			    	</tbody>
			    	<tbody>
			    		
			    	</tbody>
			    </table>
	      	</div>
	  		
	  		<input type="hidden" name="json" id="json">
	      <div class="modal-footer">
	        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
	        <button type="type" class="btn btn-primary" id="guardar">Guardar</button>
	      </div>
	      </form>
	    </div>
	  </div>
	</div>

	<table class="table table-bordered table-sm table-hover table-striped">
    	<thead>
    		<tr>
    			<th>Item</th>
    			<th>Fecha </th>
    			<th>Monto</th>
    			<th>ganancia</th>
    			<th>Productos</th>
    		</tr>
    	</thead>
    	<tbody>
    		@foreach($ventas as $venta)
    		<tr>
    			<td>{{$venta->id}}</td>
    			<td>{{$venta->created_at->format('d/m/Y')}}</td>
    			<td>{{number_format($venta->total)}}</td>
    			<td>{{number_format($venta->ganancia)}}</td>
    			<td>
    				<button class="btn btn-primary" data-toggle="modal" data-target="#venta{{$venta->id}}">Ver</button>

    				<!-- Modal -->
				<div class="modal fade" id="venta{{$venta->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
						  <div class="modal-header">
						    <h5 class="modal-title" id="exampleModalLabel">Lista de productos</h5>
						    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
						      <span aria-hidden="true">&times;</span>
						    </button>
						  </div>
						  <div class="modal-body">
						 	<table class="table table-striped table-hover">
						  		<thead>
						  		<tr>
						  			<th>Nombre</th>
						  			<th>Cantidad</th>
						  			<th>total</th>
						  		</tr>
						  	</thead>
						  	<tbody>
						 		
						 		@foreach($venta->detalle as $producto)
						 		<tr>
						 			<td>{{$producto->producto->name}}</td>
						 			<td>{{$producto->pivot->cantidad}}</td>
						 			<td>{{$producto->pivot->total}}</td>
						 		</tr>
						 		@endforeach
						  	</tbody>
						  	</table>
						  </div>
						  <div class="modal-footer">
						    <button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
						  </div>
						</div>
					</div>
				</div>
    			</td>
    		</tr>
    		
    		@endforeach
    	</tbody>
    </table>
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
			$('#ganancia').val(porcentaje * $('#cantidad').val());
			console.log(parseInt($('#precio').val()));
			let total = (parseInt($('#precio').val()) + porcentaje) * $('#cantidad').val()
			$('#total').val(total);
			$('#precio_unitario').val((parseInt($('#precio').val()) + porcentaje));
			$('#pagar').val($('#precio').val() * $('#cantidad').val())
		});

		$('#cantidad').on('keyup', function(e){
			
			$('#pagar').val($('#precio').val() * $('#cantidad').val())

			let ganancia = (($('#porcentaje').val() * $('#precio_compra').val()) / 100) * $('#cantidad').val();
			console.log(ganancia);
			$('#ganancia').val(ganancia);
		});

		//ESTABLACER NOMBRE DEL PRODUCTO
		$('#producto_id').on('change', function(e){
			console.log($("#producto_id option:selected").attr('porcentaje'))
			let name = $("#producto_id option:selected").text();
			$('#product_name').val(name);
			$('#precio').val($("#producto_id option:selected").attr('precio'));

			$('#porcentaje').val($("#producto_id option:selected").attr('porcentaje'));

			$('#precio_compra').val($("#producto_id option:selected").attr('precio_compra'));

			console.log($('#porcentaje').val())

			console.log($('#precio_compra').val())			
		});

		let productos = [];

		$('#agregar').click(function(e){

			if($('#producto_id').val() != '' && $('#product_name').val() != '' && $('#precio').val() != '' && $('#cantidad').val() != '' && $('#ganancia').val() != '' && $('#pagar').val() != ''){

				let producto = {'id': $('#producto_id').val(), 'name': $('#product_name').val(), 'precio': $('#precio').val(), 'cantidad': $('#cantidad').val(), 'ganancia': $('#ganancia').val(), 'pagar': $('#pagar').val()}

				let insertar = `<tr id="tr`+$('#producto_id').val()+`">
									<td>`+$('#producto_id').val()+`</td>
									<td>`+$('#product_name').val()+`</td>
									<td>`+$('#precio').val()+`</td>
									<td>`+$('#cantidad').val()+`</td>
									<td>`+$('#ganancia').val()+`</td>
									<td>`+$('#pagar').val()+`</td>
									<td><button type="button" class="btn btn-danger eliminar" id="`+$('#producto_id').val()+`">Eliminar</button></td>

								</tr>`;
				/*
				$('#eliminar'+$('#producto_id').val()).on('click', function(e){
					console.log("funcionando");
				});
				*/
				$('#bodyTable').append(insertar);

				productos.push(producto);

				$('#json').val(JSON.stringify(productos));

				//linpiamos los campo
				//$('#producto_id').val('')
				$("#producto_id option[value='']").attr("selected",true);
				$('#product_name').val('')
				$('#precio').val('')
				$('#cantidad').val('')
				$('#pagar').val('')
				$('#porcentaje').val('')
				$('#total').val('')
				$('#ganancia').val('')
			}
		});

		$('#guardar').click(function(){
			if(productos.length > 0){
				$.ajax({
                  url: "{{ route('store.codigo') }}",
                  headers: {'X-CSRF-TOKEN': '{{ csrf_token() }}'},
                  method: 'POST',
                  success: function(response) {
                   	console.log(response);
                  },
                  error: function(response) {
                    console.log(response.data);
                  }
                });
			}
		});
	});

	$(document).on("click", ".eliminar", function(e){
	    //console.log(e);
	    $('#tr'+e.target.id).remove();
	});
</script> 
@endsection