<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::resource('rubros','RubroController');
Route::resource('articulos','ArticuloController');
Route::resource('ventas','VentaController');
Route::resource('compras','CompraController');
Route::resource('comprobantes','ComprobanteController');
Route::resource('comprobante_detalles','ComprobanteDetalleController');
Route::get('venta', 'VentaController@venta');
Route::get('compra', 'CompraController@compra');
Route::get('sumaVenta', 'VentaController@sumaVenta');
Route::get('sumaCompra', 'CompraController@sumaCompra');