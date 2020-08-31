<template>
	<div>	
		<div class="container">
			<!--ALERT SI NO HAY SUFICIENTES PRODUCTOS-->
			<b-alert
		      :show="dismissCountDown"
		      dismissible
		      variant="danger"
		      @dismissed="dismissCountDown=0"
		      @dismiss-count-down="countDownChanged"
		      v-if="error == true"
		      fade
		    >
		      <p>{{error_message}}.</p>
		      <b-progress
		        variant="warning"
		        :max="dismissSecs"
		        :value="dismissCountDown"
		        height="4px"
		      ></b-progress>
		    </b-alert>
		    <!---->
		    <!--ALERT DE EXITO-->
		    <b-alert show variant="success" fade dismissible v-if="alert_success == true">{{alert_message}}</b-alert>
		   <!---->

			<div class="card">
				<div class="card-body">
					<h1 class="text-center">Ventas y compras</h1>
					<div class="mb-3">
						<div class="row justify-content-between">
							<div class="col-12 col-md-2">			
								<button class="btn btn-primary" @click="refrescar">Sincronizar</button>
							</div>
							<div class="col-12 col-md-2">
								<button type="button" class="btn btn-primary" @click="showModalNuevo">Nueva</button>
							</div>		
							
						</div>
					</div>
					
					<table class="table table-bordered">
						<thead>
							<tr>
								<th>Factura</th>
								<th>tipo</th>
								<th>Sub Total</th>
								<th>Iva</th>
								<th>Total</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<tr v-for="(venta, index) in ventas" :key="index">
								<td>FC-00{{venta.id}}</td>
								<td v-if="venta.type == 1">Venta</td>
								<td v-if="venta.type == 2">Compra</td>
								<td>{{venta.sub_total}}</td>
								<td>{{venta.iva}}</td>
								<td>{{venta.total}}</td>
								<td>
									<button type="button" class="btn btn-primary" @click="showModalDetalles(venta.id)">Ver</button>
									<button class="btn btn-danger">Eliminar</button>
								</td>




								<!-- Modal VER DETALLES, FACTURA -->
								<b-modal :id="'modal-detalles-'+venta.id" size="lg" title="Detalles de la venta">

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
						      				<tr v-for="(producto, index) in venta.detalle" :key="index">
						      					<td>{{producto.name}}</td>
						      					<td>{{producto.pivot.cantidad}}</td>
						      					<td>{{producto.pivot.sub_total}}</td>
						      					<td>{{producto.pivot.iva}}</td>
						      					<td>{{producto.pivot.total}}</td>
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
						      				<span>{{venta.sub_total}}</span><br>
							      			<span>{{venta.iva}}</span><br>
							   				<br>
							      			<span>{{venta.total}}</span>
						      			</div>
						      			
						      		</div>
								</b-modal>

							</tr>
						</tbody>
					</table>

					<div class="overflow-auto">
						<b-pagination v-model="currentPage" @change="paginar($event)" :per-page="per_page"  :total-rows="total_paginas" size="sm"></b-pagination>
					</div>


					<!-- Modal NUEVA VENTA-->
					<b-modal id="modal-nuevo" size="lg" title="Realizar ua nueva venta" hide-footer>
					
			      		<form method="post" @submit.prevent=""><!--Formulario-->

							<select name="type" id="type" v-model="type" class="form-control mb-3">
								<option value="">Venta ó compra</option>
								<option value="1">Venta</option>
								<option value="2">Compra</option>
							</select>
							<div v-if="type != ''">
								<div class="form-row">
									<div class="form-group col-md-3">
										<label for="producto">Producto:</label>
									    <select class="form-control" v-model="articulo.id" @change="establecer_nombre(articulo.id)">
										  <option value="0">Seleecion producto</option>
										  <option v-for="(prod, index) in inventario" :key="index" :value="prod.inventario.id">{{prod.inventario.name}}</option>
										</select>
									</div>

									<div class="form-group col-md-3">
										<label for="cantidad">Cantidad disponible:</label>
										<input type="number" name="cantidad_disponible" id="cantidad_disponible" placeholder="" class="form-control" v-model="cantidad_disponible" disabled="">
									</div>

									<div class="form-group col-md-3">
										<label for="cantidad">Cantidad al menor:</label>
										<input type="number" name="cantidad" id="cantidad" placeholder="Cantidad" class="form-control" v-model="articulo.cantidad">
									</div>

									<div class="form-group col-md-3">
										<label class="text-center" for="">Acción:</label><br>
										<button class="btn btn-primary btn-block" type="button" @click="agregar_producto">Agregar</button>
									</div>
								</div>
							</div>

							<table class="table table-bordered">
								<thead>
									<tr>
										<th>Producto</th>
										<th>cantidad</th>
										<th>Sub total</th>
										<th>Iva</th>
										<th>Total</th>
										<th>Acciones</th>
									</tr>
								</thead>
								<tbody>
									<tr v-for="(produc_enviar, index) in productos" :key="index">
										<td>{{produc_enviar.nombre}}</td>
										<td>{{produc_enviar.cantidad}}</td>
										<td>{{produc_enviar.sub_total}}</td>
										<td>{{produc_enviar.iva}}</td>
										<td>{{produc_enviar.total}}</td>
										<td>
											<button class="btn btn-danger" type="button" @click="eliminar(index)">Eliminar</button>
										</td>
									</tr>
								</tbody>
							</table>

							<div class="row">
						      			<div class="col-md-7">
						      				
						      			</div>

						      			<div class="col-md-2 text-right">
						      				<span class="font-weight-bold small">Sub total:</span><br>
						      				<span class="font-weight-bold small">iva:</span><br>
						      				<br>
						      				<span class="font-weight-bold small">Total:</span>

						      			</div>

						      			<div class="col-md-3">
						      				<span class="small">{{sub_total_total}}</span><br>
							      			<span class="small">{{iva_total}}</span><br>
							   				<br>
							      			<span class="small">{{total_total}}</span>
						      			</div>
						      			
						      		</div>
				      	
					      	<div class="modal-footer">
					        	<button type="submit" class="btn btn-primary" @click="vender">Vender</button>
					      	</div>
				      	</form>

					</b-modal>



				</div>
			</div>
		</div>
	</div>
</template>

<script>
	export default{
		data(){
			return{
				ventas: [],
				inventario: [],
				productos: [],//LISTA DE PRODUCTOS QUE VOY A AGREGAR
				articulo: {
					id: 0,
					nombre: "",
					cantidad: "",
					sub_total: "",
					iva: "",
					total: ""
				},
				sub_total: 0,
				iva: 0,
				total: 0,
				type: "",
				piso_venta: "",
				currentPage: 0,
				per_page: 0,
				total_paginas: 0,
				cantidad_disponible: "",
				error: false,
				error_message: "",
				dismissSecs: 10,//MODAL 
		        dismissCountDown: 0,
		        showDismissibleAlert: false,
		        alert_success: false,
		        alert_message: ""
			}
		},
		methods:{
			get_ventas(){

				axios.get('/api/get-ventas').then(response => {
					console.log(response.data.data);
					this.per_page = response.data.per_page;
					this.total_paginas = response.data.total;
					this.ventas = response.data.data

					console.log(this.despachos)
				}).catch(e => {
					console.log(e.response)
				});

			},
			get_datos(){
				//SOLICITO LOS PISOS DE VENTAS Y PRODUCTOS
				axios.get('/api/ventas-datos-create').then(response => {

					console.log(response);
					this.inventario = response.data
				}).catch(e => {

				});
			},
			showModalNuevo(){
				
				this.get_datos();
				this.$bvModal.show("modal-nuevo")
			},
			establecer_nombre(id){//COLOCAR EL NOMBRE AL PRODUCTO QUE ESTOY AGREGANDO
				let resultado = this.inventario.find(element => element.inventario.id == id)
				this.articulo.nombre = resultado.inventario.name;
				
				this.articulo.sub_total = resultado.inventario.precio.sub_total_menor
				this.articulo.iva = resultado.inventario.precio.iva_menor
				this.articulo.total = resultado.inventario.precio.total_menor
				
				this.cantidad_disponible = resultado.cantidad;
				
				console.log(this.articulo);

			},
			agregar_producto(){
				
				this.articulo.sub_total *= this.articulo.cantidad
				this.articulo.iva *= this.articulo.cantidad
				this.articulo.total *= this.articulo.cantidad

				this.productos.push(this.articulo);
					
				//console.log(this.productos)
				this.articulo = {id: 0, nombre: "", cantidad: "", sub_total: "", iva: "", total: ""};
			},
			eliminar(index){

					this.productos.splice(index, 1);
				
			},
			paginar(event){

				axios.get('/api/get-ventas?page='+event).then(response => {
					console.log(response.data)
					this.per_page = response.data.per_page;
					this.total_paginas = response.data.total;
					this.ventas = response.data.data
			
				}).catch(e => {
					console.log(e.response)
				});
			},
			showModalDetalles(id){
				this.$bvModal.show("modal-detalles-"+id)
			},
			vender(){
				this.error = false;
				axios.post('/api/ventas', {venta: {sub_total: this.sub_total, iva: this.iva, total: this.total, type: this.type},productos: this.productos}).then(response => {
					console.log(response.data)
					if (response.data.errors != null) {//COMPROBAR SI HAY ERRORES DE INSUFICIENCIA DE PRODUCTOS
						this.error_message = response.data.errors
						this.error = true;
						this.showAlert();
						this.articulo = {id: 0, nombre: "", cantidad: "", sub_total: "", iva: "", total: ""};
						this.cantidad_disponible = ""
						this.productos = [];
					}else{
						this.articulo = {id: 0, nombre: "", cantidad: "", sub_total: "", iva: "", total: ""};
						this.cantidad_disponible = ""
						this.ventas.splice(0,0, response.data);
						this.productos = [];
					}
					
					
				}).catch(e => {

					console.log(e.response)
				})
				
				this.$bvModal.hide("modal-nuevo")
			},
			countDownChanged(dismissCountDown) {//MODAL
		        this.dismissCountDown = dismissCountDown
		    },
		    showAlert() {//MODAL
		    	this.dismissCountDown = this.dismissSecs
		    },
			refrescar(){
				this.alert_success = false;
				this.error = false
				//OBTENEMOS MI ID DE PISO DE VENTA
				axios.get('/api/get-piso-venta-id').then(response => {
					let piso_venta_id = response.data;
					//console.log(piso_venta_id)
					//OBTENEMOS DE LA WEB LA ULTIMA VENTA QUE TIENE REGISTRADA CON NUESTRO PISO DE VENTA
					axios.get('/api/ultima-venta/'+piso_venta_id).then(response => {//WEB

						let ultima_venta = response.data.id_extra
						//console.log(ultima_venta)

						//OBTENEMOS TODAS LAS VENTAS QUE SEAN MAYOR AL ID_EXTRA QUE ACABO DE CONSEGUIR
						axios.get('/api/ventas-sin-registrar/'+piso_venta_id+'/'+ultima_venta).then(response => {

							console.log(response.data)
							let ventas = response.data
							//VALIDACION SI TRAJO ALGUNA VENTA
							if (ventas.length > 0) {


							//EN ESE CASO REGISTRAMOS LAS VENTAS EN LA WEB
							axios.post('/api/registrar-ventas', {ventas: ventas, piso_venta_id: piso_venta_id}).then(response => {

								console.log(response.data)
								if (response.data == true) {
									this.alert_message = "la sincronizacion fue exitosa";
									this.alert_success = true;
								}else{
									this.error_message = "Ha ocurrido un error."
									this.error = true;
									this.showAlert();
								}
							}).catch(e => {
								console.log(e.response)
							})
							}else{
								this.alert_message = "Usted esta al dia con la sincronizacion";
								this.alert_success = true;
							}
						}).catch(e => {
							console.log(e.response)
						})
					}).catch(e => {
						console.log(e.response)
					})

				}).catch(e => {
					console.log(e.response)
				});
			}
		},
		computed:{
			sub_total_total(){
				let subtotal = 0;

				this.productos.forEach(producto => {

					subtotal += producto.sub_total

				})
				this.sub_total = subtotal;
				
				return subtotal;
			},
			iva_total(){
				let iva = 0;

				this.productos.forEach(producto => {

					iva += producto.iva;
				})

				this.iva = iva;

				return iva;
			},
			total_total(){
				let total = 0;

				this.productos.forEach(producto => {

					total += producto.total

				})
				this.total = total

				return total;
			}
		},
		created(){

			this.get_ventas();
		}
	}
</script>