<template>
	<div>	
		<div class="container">
			<div class="card">
				<div class="card-body">
					<h1 class="text-center">Ventas</h1>
					<div class="mb-3">
						<div class="row justify-content-between">
							<div class="col-12 col-md-2">			
								<button class="btn btn-primary ">Enviar ventas</button>
							</div>
							<div class="col-12 col-md-2">
								<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-nueva-venta">Nueva</button>
							</div>		
							
						</div>
					</div>
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Factura</th>
								<th>cantidad de productos</th>
								<th>Sub Total</th>
								<th>Iva</th>
								<th>Total</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>5</td>
								<td>FC-00</td>
								<td>12356</td>
								<td>2121</td>
								<td>135166</td>
								<td>
									<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#detalles-venta">Ver</button>
									<button class="btn btn-danger">Eliminar</button>
								</td>

								<!-- Modal VER DETALLES, FACTURA -->
								<div class="modal fade" id="detalles-venta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
								  	<div class="modal-dialog modal-lg">
								    	<div class="modal-content">
								      		<div class="modal-header">
								        		<h5 class="modal-title" id="exampleModalLabel">Detalles de venta</h5>
								        		<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								          		<span aria-hidden="true">&times;</span>
								        		</button>
								      		</div>
									      	<div class="modal-body">
									      		<table class="table table-bordered">
									      			<thead>
										      			<tr>
										      				<th>Producto</th>
										      				<th>Cantidad</th>
										      				<th>Subtotal</th>
										      				<th>Iva</th>
										      				<th>Total</th>
										      			</tr>
									      			</thead>

									      			<tbody>
									      				<tr>
									      					<td>Harina pan</td>
									      					<td>2 kg</td>
									      					<td>230000</td>
									      					<td>60000</td>
									      					<td>260000</td>
									      				</tr>
									      			</tbody>

									      		</table>

									      		<div class="row">
									      			<div class="col-md-7">
									      				
									      			</div>

									      			<div class="col-md-2 text-right">
									      				<span class="font-weight-bold">Sub total:</span><br>
									      				<span class="font-weight-bold">iva:</span><br>
									      				<br>
									      				<span class="font-weight-bold">Total:</span>

									      			</div>

									      			<div class="col-md-3">
									      				<span> 230000</span><br>
										      			<span> 60000</span><br>
										      			<br>
										      			<span> 290000</span>
									      			</div>
									      			
									      		</div>
									      	</div>

									      	<div class="modal-footer">
									        	<button type="button" class="btn btn-primary" data-dismiss="modal">Cerrar</button>
									      	</div>
								    	</div>
								  	</div>
								</div>

							</tr>
						</tbody>
					</table>


					<!-- Modal NUEVA VENTA-->
					<div class="modal fade" id="modal-nueva-venta" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
						<div class="modal-dialog modal-lg">
					    	<div class="modal-content">
					      		<div class="modal-header">
						        	<h5 class="modal-title" id="exampleModalLabel">Nueva venta</h5>
						        	<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						         	<span aria-hidden="true">&times;</span>
						        	</button>
					      		</div>
					      		<form action="/" method="post"><!--Formulario-->
						      	<div class="modal-body">

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
											  <option>Al menor</option>
											  <option>Al mayor</option>
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
						        	<button type="submit" class="btn btn-primary" data-dismiss="modal">Vender</button>
						      	</div>
						      	</form>
					    	</div>
					  	</div>
					</div>



				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		
	}
</script>