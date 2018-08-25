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

//CONTROLADOR PROVEEDOR
Route::get('crearProveedor', 'MInventario\ProveedorController@CrearProveedor')->name('crearProveedor');//cargar la vista para crear un proveedor
Route::post('guardarProveedor', 'MInventario\ProveedorController@GuardarProveedor')->name('guardarProveedor');//Guardar la informacion del proveedor
Route::get('proveedores', 'MInventario\ProveedorController@ObtenerProveedores')->name('proveedores');//Obtiene la lista de proveedores

//CONTROLADOR CATEGORIAS
Route::get('crearCategoria', 'MInventario\CategoriaController@CrearCategoria')->name('crearCategoria');//cargar la vista para crear una categoria
Route::post('guardarCategoria', 'MInventario\CategoriaController@GuardarCategoria')->name('guardarCategoria');//Guardar la informacion de la categoria
Route::get('categorias', 'MInventario\CategoriaController@ObtenerCategorias')->name('categorias');//Obtiene la lista de categorias

//CONTROLADOR TIPODOCUMENTO
Route::get('crearTipoDocumento', 'MSistema\TipoDocumentoController@CrearTipoDocumento')->name('crearTipoDocumento');//cargar la vista para crear un tipo de documento
Route::post('guardarTipoDocumento', 'MSistema\TipoDocumentoController@GuardarTipoDocumento')->name('guardarTipoDocumento');//Guardar la informacion del tipo documento
Route::get('tiposDocumentos', 'MSistema\TipoDocumentoController@ObtenerTiposDocumentos')->name('tiposDocumentos');//Obtiene la lista de tipos de documentos

