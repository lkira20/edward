<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
//INVENTARIO
Route::get('/inventario', 'InventarioController@index')->name('inventario.index');
//VENTAS
Route::get('/ventas', 'VentasController@index')->name('ventas.index');
//DESPACHOS
Route::get('/despachos', 'DespachosController@index')->name('despachos.index');
//COMPRAS
Route::get('/compras', 'ComprasController@index')->name('compras.index');
//DESPACHOS ALMACEN
Route::get('/despachos-almacen', 'DespachosController@index_almacen')->name('despachos.almacen.index');
Route::get('/despachos/create', 'DespachosController@create')->name('despachos.create');
Route::post('/despachos-almacen', 'DespachosController@store')->name('despachos.store');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//RUTA DE PRUEBAS
Route::get('/prueba', 'InventarioController@prueba');


//RUTAS APIS
Route::prefix('api')->group(function(){
	//USUARIO
	Route::get('/get-id', 'UsersController@get_id');	
	//INVENTARIO
	Route::get('/get-inventario', 'InventarioController@get_inventario');

	//DESPACHOS
	Route::get('/get-despachos', 'DespachosController@get_despachos');
	Route::post('/confirmar-despacho', 'DespachosController@confirmar_despacho');
	Route::post('/negar-despacho', 'DespachosController@negar_despacho');
	Route::get('/get-despachos-sin-confirmacion/{piso_venta_id}', 'DespachosController@get_despachos_sin_confirmacion');
	Route::post('/get-despachos-confirmados', 'DespachosController@get_despachos_confirmados');
	Route::post('/actualizar-confirmados', 'DespachosController@actualizar_confirmaciones');

	Route::post('/get-despachos-web', 'DespachosController@get_despachos_web');
	Route::get('/ultimo-despacho', 'DespachosController@ultimo_despacho');
	Route::post('/registrar-despachos-piso-venta', 'DespachosController@registrar_despacho_piso_venta');

});