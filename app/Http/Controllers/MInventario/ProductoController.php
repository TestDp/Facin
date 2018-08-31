<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/08/2018
 * Time: 12:40 PM
 */

namespace App\Http\Controllers\MInventario;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MInventario\AlmacenServicio;
use Facin\Negocio\Logica\MInventario\CategoriaServicio;
use Facin\Negocio\Logica\MInventario\ProductoServicio;
use Facin\Negocio\Logica\MInventario\ProveedorServicio;
use Facin\Negocio\Logica\MSistema\UnidadDeMedidaServicio;
use Facin\Validaciones\MInventario\ProductoValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ProductoController extends  Controller
{
    protected  $productoServicio;
    protected  $proveedorServicio;
    protected  $almacenServicio;
    protected  $categoriaServicio;
    protected  $unidadDeMedidaServicio;
    protected  $productoValidaciones;

    public function __construct(ProveedorServicio $proveedorServicio,AlmacenServicio $almacenServicio,
                                CategoriaServicio $categoriaServicio,UnidadDeMedidaServicio $unidadDeMedidaServicio,
                                ProductoServicio $productoServicio,ProductoValidaciones $productoValidaciones){
        $this->middleware('auth');
        $this->proveedorServicio = $proveedorServicio;
        $this->almacenServicio = $almacenServicio;
        $this->categoriaServicio = $categoriaServicio;
        $this->unidadDeMedidaServicio = $unidadDeMedidaServicio;
        $this->productoServicio = $productoServicio;
        $this->productoValidaciones = $productoValidaciones;
    }

    //Metodo para cargar  la vista de crear producto
    public function CrearProducto(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $idSede = Auth::user()->Sede->id;
        $proveedores = $this->proveedorServicio->ObtenerListaProveedores($idEmpreesa);
        $almacenes = $this->almacenServicio->ObtenerListaAlmacen($idSede);
        $categorias = $this->categoriaServicio->ObtenerListaCategorias($idEmpreesa);
        $unidades = $this->unidadDeMedidaServicio->ObtenerListaUnidades();
        $view = View::make('MInventario/Producto/crearProducto',
            array('listProveedores'=>$proveedores,'listAlmacenes'=>$almacenes,'listCategorias'=>$categorias,'listUnidades'=>$unidades));
            //->with('listProveedores',$proveedores,'listAlmacenes',$almacenes);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Producto/crearProducto');
    }


    //Metodo para guarda el producto
    public  function GuardarProducto(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $this->productoValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $repuesta = $this->productoServicio->GuardarProducto($request);
            if($repuesta == true){
                $idEmpreesa = Auth::user()->Sede->Empresa->id;
                $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
                $view = View::make('MInventario/Producto/listaProductos')->with('listProductos',$productos);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->productoServicio->GuardarProducto($request);
            }
        }else return view('MInventario/Producto/listaProductos');
    }


    //Metodo para obtener toda  la lista de productos por empresa
    public  function ObtenerProductosEmpresa(Request $request){
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $view = View::make('MInventario/Producto/listaProductos')->with('listProductos',$productos);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Producto/listaProductos');
    }
}