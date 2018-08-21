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
    return view('auth.login');
});

Route::get('/welcome', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('crearProveedor', 'MInventario\ProveedorController@CrearProveedor')->name('crearProveedor');//cargar la vista para crear un proveedor
Route::post('guardarProveedor', 'MInventario\ProveedorController@GuardarProveedor')->name('guardarProveedor');//Guardar la informacion del proveedor
Route::get('proveedores', 'MInventario\ProveedorController@ObtenerProveedores')->name('proveedores');//cargar la lista de proveedores