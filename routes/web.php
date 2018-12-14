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
Route::get('crearUnidad', 'MEmpresa\UnidadDeMedidaController@CrearUnidad')->name('crearUnidad');//cargar la vista para crear una unidad
Route::post('guardarUnidad', 'MEmpresa\UnidadDeMedidaController@GuardarUnidad')->name('guardarUnidad');//Guardar la informacion de la unidad
Route::get('unidades', 'MEmpresa\UnidadDeMedidaController@ObtenerUnidadesEmpresa')->name('unidades');//Obtiene la lista de tipos de la unidad

//CONTROLADOR ROL
Route::get('crearRol', 'MSistema\RolController@CrearRol')->name('crearRol');//cargar la vista para crear un rol
Route::get('editarRol/{idRol}', 'MSistema\RolController@EditarRol')->name('editarRol');//cargar la vista para editar un rol
Route::post('guardarRol', 'MSistema\RolController@GuardarRol')->name('guardarRol');//Guardar la informacion del rol
Route::get('roles', 'MSistema\RolController@ObtenerRoles')->name('roles');//Obtiene la lista de tipos de roles

//CONTROLADOR USUARIOS
Route::get('crearUsuario', 'MSistema\UsuarioController@CrearUsuarioEmpresa')->name('crearUsuario');//cargar la vista para crear un usuario
Route::get('editarUsuario/{idUsuario}','MSistema\UsuarioController@EditarUsuarioEmpresa')->name('editarUsuario');//Cargar la vista para editar un usuario
Route::post('guardarUsuario', 'MSistema\UsuarioController@GuardarUsuarioEmpresa')->name('guardarUsuario');//Guardar la informacion del usuario
Route::get('usuarios', 'MSistema\UsuarioController@ObtenerUsuarios')->name('usuarios');//Obtiene la lista de usuarios
Route::get('/register/verify/{code}', 'MSistema\UsuarioController@verifarCorreo'); //verificar correo electronico

//CONTROLADOR TIPODEPRODUCTOS
Route::get('crearTipoProducto', 'MSistema\TipoDeProductoController@CrearTipoDeProducto')->name('crearTipoProducto');//cargar la vista para crear un tipo de producto
Route::post('guardarTipoProducto', 'MSistema\TipoDeProductoController@GuardarTipoProducto')->name('guardarTipoProducto');//Guardar la informacion del usuario
Route::get('tiposProductos', 'MSistema\TipoDeProductoController@ObtenerTiposProductos')->name('tiposProductos');//Obtiene la lista de tipos de productos

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
Route::get('infoProducto/{idProducto}','MInventario\ProductoController@ObtenerProductoProveedor')->name('infoProducto');//obtiene la informacion del producto
Route::get('guardarEquivalencia/{idProductoP}/{idProductoS}/{cantidad}','MInventario\ProductoController@GuardarEquivalencia')->name('guardarEquivalencia');

//CONTROLADOR INVENTARIO
Route::get('actualizarInventario', 'MInventario\InventarioController@ActualizarInvetario')->name('actualizarInventario');//cargar la vista para actulizar el inventario o la cantidad de un producto
Route::post('guardarInventario', 'MInventario\InventarioController@GuardarInventario')->name('guardarInventario');//actualizar el inventario de en la base de datos
//Route::get('productos', 'MInventario\InventarioController@ObtenerProductosEmpresa')->name('productos');//Obtiene la lista de los almacenes

//CONTROLADOR SEDES
Route::get('crearSede', 'MEmpresa\SedeController@CrearSede')->name('crearSede');//cargar la vista para crear una sede
Route::post('guardarSede', 'MEmpresa\SedeController@GuardarSede')->name('guardarSede');//Guardar la informacion de la sede
Route::get('sedes', 'MEmpresa\SedeController@ObtenerSedes')->name('sedes');//Obtiene la lista de sedes

//CONTROLADOR DE EQUIVALENCIAS
Route::get('equivalenciasProducto/{idProducto}','MInventario\EquivalenciaController@ObtenerEquivalenciasProducto')->name('equivalenciasProducto');//obtiene la informacion de las equivalencias
Route::get('eliminarEquivalencia/{idProductoP}/{idProductoS}','MInventario\EquivalenciaController@EliminarEquivalencia')->name('EliminarEquivalencia');//Elimina las equivalencias asosiadas a un producto

//CONTROLADOR DE CLIENTE
Route::post('guardarCliente', 'MCliente\ClienteController@GuardarCliente')->name('guardarCliente');//Guardar la informacion del cliente

//CONTROLADOR FACTURA
Route::get('formPedido', 'MFacturacion\FacturaController@ObtenerFormularioCrearPedido')->name('formPedido');//cargar la vista para crear un pedido
Route::post('guardarPedido', 'MFacturacion\FacturaController@CrearFactura')->name('guardarPedido');//Guardar el pedido
Route::post('confirmarProductosPedido', 'MFacturacion\FacturaController@ConfirmarProductosPedido')->name('confirmarProductosPedido');//Guardar el pedido
Route::get('listaPedidos/{idEstado}', 'MFacturacion\FacturaController@getVistaListaPedidos')->name('listaPedidos');//Obtiene la lista de los pedidos
Route::get('editarPedido/{idFactura}', 'MFacturacion\FacturaController@EditarFactura')->name('editarPedido');//Obtiene la vista donde se edita el producto
