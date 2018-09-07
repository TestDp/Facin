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

//CONTROLADOR TIPODOCUMENTO
Route::get('crearTipoDocumento', 'MSistema\TipoDocumentoController@CrearTipoDocumento')->name('crearTipoDocumento');//cargar la vista para crear un tipo de documento
Route::post('guardarTipoDocumento', 'MSistema\TipoDocumentoController@GuardarTipoDocumento')->name('guardarTipoDocumento');//Guardar la informacion del tipo documento
Route::get('tiposDocumentos', 'MSistema\TipoDocumentoController@ObtenerTiposDocumentos')->name('tiposDocumentos');//Obtiene la lista de tipos de documentos

//CONTROLADOR UNIDADDEMEDIDA
Route::get('crearUnidad', 'MSistema\UnidadDeMedidaController@CrearUnidad')->name('crearUnidad');//cargar la vista para crear una unidad
Route::post('guardarUnidad', 'MSistema\UnidadDeMedidaController@GuardarUnidad')->name('guardarUnidad');//Guardar la informacion de la unidad
Route::get('unidades', 'MSistema\UnidadDeMedidaController@ObtenerUnidades')->name('unidades');//Obtiene la lista de tipos de la unidad

//CONTROLADOR ROL
Route::get('crearRol', 'MSistema\RolController@CrearRol')->name('crearRol');//cargar la vista para crear un rol
Route::post('guardarRol', 'MSistema\RolController@GuardarRol')->name('guardarRol');//Guardar la informacion del rol
Route::get('roles', 'MSistema\RolController@ObtenerRoles')->name('roles');//Obtiene la lista de tipos de roles

//CONTROLADOR USUARIOS
Route::get('crearUsuario', 'MSistema\UsuarioController@CrearUsuarioEmpresa')->name('crearUsuario');//cargar la vista para crear un usuario
Route::post('guardarUsuario', 'MSistema\UsuarioController@GuardarUsuarioEmpresa')->name('guardarUsuario');//Guardar la informacion del usuario
Route::get('usuarios', 'MSistema\UsuarioController@ObtenerUsuarios')->name('usuarios');//Obtiene la lista de usuarios

//CONTROLADOR PROVEEDOR
Route::get('crearProveedor', 'MInventario\ProveedorController@CrearProveedor')->name('crearProveedor');//cargar la vista para crear un proveedor
Route::post('guardarProveedor', 'MInventario\ProveedorController@GuardarProveedor')->name('guardarProveedor');//Guardar la informacion del proveedor
Route::get('proveedores', 'MInventario\ProveedorController@ObtenerProveedores')->name('proveedores');//Obtiene la lista de proveedores

//CONTROLADOR CATEGORIAS
Route::get('crearCategoria', 'MInventario\CategoriaController@CrearCategoria')->name('crearCategoria');//cargar la vista para crear una categoria
Route::post('guardarCategoria', 'MInventario\CategoriaController@GuardarCategoria')->name('guardarCategoria');//Guardar la informacion de la categoria
Route::get('categorias', 'MInventario\CategoriaController@ObtenerCategorias')->name('categorias');//Obtiene la lista de categorias

//CONTROLADOR ALMACEN
Route::get('crearAlmacen', 'MInventario\AlmacenController@CrearAlmacen')->name('crearAlmacen');//cargar la vista para crear un almacen
Route::post('guardarAlmacen', 'MInventario\AlmacenController@GuardarAlmacen')->name('guardarAlmacen');//Guardar la informacion del almacen
Route::get('almacenes', 'MInventario\AlmacenController@ObtenerAlmacenes')->name('almacenes');//Obtiene la lista de los almacenes

//CONTROLADOR PRODUCTO
Route::get('crearProducto', 'MInventario\ProductoController@CrearProducto')->name('crearProducto');//cargar la vista para crear un producto
Route::post('guardarProducto', 'MInventario\ProductoController@GuardarProducto')->name('guardarProducto');//Guardar la informacion del producto
Route::get('productos', 'MInventario\ProductoController@ObtenerProductosEmpresa')->name('productos');//Obtiene la lista de los producto

//CONTROLADOR INVENTARIO
Route::get('actualizarInventario', 'MInventario\InventarioController@ActualizarInvetario')->name('actualizarInventario');//cargar la vista para actulizar el inventario o la cantidad de un producto
Route::post('guardarInventario', 'MInventario\InventarioController@GuardarInventario')->name('guardarInventario');//actualizar el inventario de en la base de datos
//Route::get('productos', 'MInventario\InventarioController@ObtenerProductosEmpresa')->name('productos');//Obtiene la lista de los almacenes

//CONTROLADOR SEDES
Route::get('crearSede', 'MEmpresa\SedeController@CrearSede')->name('crearSede');//cargar la vista para crear una sede
Route::post('guardarSede', 'MEmpresa\SedeController@GuardarSede')->name('guardarSede');//Guardar la informacion de la sede
Route::get('sedes', 'MEmpresa\SedeController@ObtenerSedes')->name('sedes');//Obtiene la lista de sedes