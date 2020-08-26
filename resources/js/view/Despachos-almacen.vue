<template>
	<div>	
		<div class="container">
			<div class="card">
				<div class="card-body">
					<h1 class="text-center">Despachos-almacen</h1>
					<div class="mb-3">
						<div class="row justify-content-between">
							<div class="col-12 col-md-4">			
					
							</div>
							<div class="col-12 col-md-4">
								<div class="ml-auto">
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-nuevo-despacho">
									  Nuevo
									</button>
									<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalRetiro">Retirar</button>
								</div>
							</div>		
							
						</div>
					</div>
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Fecha</th>
								<th>Piso de venta</th>
								<th>Tipo</th>
								<th>Confirmado</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>FC-00</td>
								<th>la segundera</th>
								<td>Despacho</td>
								<td class="small font-weight-bold">No se ha confirmado</td>
								<td>
									<button class="btn btn-primary" data-toggle="modal" data-target="#modalVer">Ver</button>
								</td>
								<!-- Modal PARA VER LOS DETALLES -->
								<div class="modal fade" id="modalVer" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  	<div class="modal-dialog">
								    	<div class="modal-content">
								      		<div class="modal-header">
								        		<h5 class="modal-title" id="exampleModalLabel">Detalles</h5>
								        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          		<span aria-hidden="true">&times;</span>
								        		</button>
								      		</div>
								      		<div class="modal-body">
								        	
								      		<table class="table table-bordered">
											<thead>
												<tr>
													<th>Producto</th>
													<th>Tipo</th>
													<th>cantidad</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>Harina pan</td>
													<td>Al menor</td>
													<td>10</td>
												</tr>
											</tbody>
										</table>

								      		</div>
								      		<div class="modal-footer">
								        		<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
								      		</div>
								    	</div>
								  	</div>
								</div>
							</tr>
							<tr>
								<td>FC-00</td>
								<th>la segundera</th>
								<td>retiro</td>
								<td class="small font-weight-bold">confirmado</td>
								<td>
									<button class="btn btn-primary">Ver</button>
								</td>
							</tr>
							<tr>
								<td>FC-00</td>
								<th>la segundera</th>
								<td>Despacho</td>
								<td class="small font-weight-bold">Denegado</td>
								<td>
									<button class="btn btn-primary">Ver</button>
								</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>


		<!-- Modal NUEVO DESPACHO-->
		<div class="modal fade" id="modal-nuevo-despacho" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
		    	<div class="modal-content">
		      		<div class="modal-header">
			        	<h5 class="modal-title" id="exampleModalLabel">Hacer un nuevo despacho</h5>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         	<span aria-hidden="true">&times;</span>
			        	</button>
		      		</div>
		      		<form action="/despachos-almacen" method="post"><!--Formulario-->
			      	<div class="modal-body">
				        <select class="form-control">
						  <option>Seleccione un piso de venta</option>
						</select>

						<input type="hidden" name="tipo" value="1"><!--ESTABLECER SI ES UN DESPACHO O UN RETIRO-->

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="producto">Producto:</label>
							    <select class="form-control">
								  <option>Seleecion producto</option>
								</select>
							</div>

							<div class="form-group col-md-3">
								<label>Tipo de despacho:</label><br>
								<select class="form-control">
								  <option>Seleecione el tipo</option>
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="cantidad">Cantidad:</label>
								<input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control">
							</div>

							<div class="form-group col-md-3">
								<label class="text-center" for="">Acción:</label><br>
								<button class="btn btn-primary btn-block">Agregar</button>
							</div>
						</div>

						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Producto</th>
									<th>Tipo</th>
									<th>cantidad</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Harina pan</td>
									<td>Al menor</td>
									<td>10</td>
									<td>
										<button class="btn btn-danger">Eliminar</button>
									</td>
								</tr>
							</tbody>
						</table>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-primary" data-dismiss="modal">Despachar</button>
			      	</div>
			      	</form>
		    	</div>
		  	</div>
		</div>


		<!-- Modal RETIRO DESPACHO-->
		<div class="modal fade" id="modalRetiro" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-lg">
		    	<div class="modal-content">
		      		<div class="modal-header">
			        	<h5 class="modal-title" id="example">Retirar productos de los pisos de venta</h5>
			        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			         	<span aria-hidden="true">&times;</span>
			        	</button>
		      		</div>
		      		<form action="/despachos-almacen" method="post"><!--Formulario-->
			      	<div class="modal-body">
				        <select class="form-control">
						  <option>Seleccione un piso de venta</option>
						</select>

						<input type="hidden" name="tipo" value="2"><!--ESTABLECER SI ES UN DESPACHO O UN RETIRO-->

						<div class="form-row">
							<div class="form-group col-md-3">
								<label for="producto">Producto:</label>
							    <select class="form-control">
								  <option>Seleecion producto</option>
								</select>
							</div>

							<div class="form-group col-md-3">
								<label>Tipo:</label><br>
								<select class="form-control">
								  <option>mayor o menor</option>
								</select>
							</div>
							<div class="form-group col-md-2">
								<label for="cantidad">Cantidad:</label>
								<input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control" disabled>
							</div>

							<div class="form-group col-md-2">
								<label for="cantidad_retirar">retirar:</label>
								<input type="number" name="cantidad_retirar" id="cantidad-retirar" placeholder="retirar" class="form-control">
							</div>

							<div class="form-group col-md-2">
								<label class="text-center" for="">Acción:</label><br>
								<button class="btn btn-primary btn-block">Agregar</button>
							</div>
						</div>

						<table class="table table-bordered">
							<thead>
								<tr>
									<th>Producto</th>
									<th>Tipo</th>
									<th>cantidad</th>
									<th>Acciones</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>Harina pan</td>
									<td>Al menor</td>
									<td>10</td>
									<td>
										<button class="btn btn-danger">Eliminar</button>
									</td>
								</tr>
							</tbody>
						</table>
			      	</div>
			      	<div class="modal-footer">
			        	<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			        	<button type="submit" class="btn btn-primary" data-dismiss="modal">Despachar</button>
			      	</div>
			      	</form>
		    	</div>
		  </div>
		</div>



	</div>
</template>

<script>
	export default{
		
	}
</script>