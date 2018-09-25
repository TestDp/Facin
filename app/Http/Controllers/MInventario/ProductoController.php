<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/08/2018
 * Time: 12:40 PM
 */

namespace App\Http\Controllers\MInventario;


use App\Http\Controllers\Controller;
use Facin\Datos\Modelos\MInventario\GrupoDeProductos;
use Facin\Negocio\Logica\MInventario\AlmacenServicio;
use Facin\Negocio\Logica\MInventario\CategoriaServicio;
use Facin\Negocio\Logica\MInventario\ProductoServicio;
use Facin\Negocio\Logica\MInventario\ProveedorServicio;
use Facin\Negocio\Logica\MSistema\TipoDeProductoServicio;
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
    protected  $tipoProductoServicio;
    protected  $grupoProductos;

    public function __construct(ProveedorServicio $proveedorServicio,AlmacenServicio $almacenServicio,
                                CategoriaServicio $categoriaServicio,UnidadDeMedidaServicio $unidadDeMedidaServicio,
                                ProductoServicio $productoServicio,ProductoValidaciones $productoValidaciones,
                                TipoDeProductoServicio $tipoProductoServicio,GrupoDeProductos $grupoProductos){
        $this->middleware('auth');
        $this->proveedorServicio = $proveedorServicio;
        $this->almacenServicio = $almacenServicio;
        $this->categoriaServicio = $categoriaServicio;
        $this->unidadDeMedidaServicio = $unidadDeMedidaServicio;
        $this->productoServicio = $productoServicio;
        $this->productoValidaciones = $productoValidaciones;
        $this->tipoProductoServicio = $tipoProductoServicio;
        $this->grupoProductos = $grupoProductos;
    }

    //Metodo para cargar  la vista de crear producto
    public function CrearProducto(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $proveedores = $this->proveedorServicio->ObtenerListaProveedores($idEmpreesa);
        $almacenes = $this->almacenServicio->ObtenerListaAlmacenXEmpresa($idEmpreesa);
        $categorias = $this->categoriaServicio->ObtenerListaCategorias($idEmpreesa);
        $unidades = $this->unidadDeMedidaServicio->ObtenerListaUnidades();
        $tiposProductos = $this->tipoProductoServicio->ObtenerListaTipoProductos();
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa);
        $view = View::make('MInventario/Producto/crearProducto',
            array('listProveedores'=>$proveedores,'listAlmacenes'=>$almacenes,'listCategorias'=>$categorias,
                'listUnidades'=>$unidades,'listTiposProductos'=>$tiposProductos,'listProductos'=>$productos));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Producto/crearProducto');
    }


    //Metodo para guarda el producto
    public  function GuardarProducto(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        if($request->EsCombo){
            $this->productoValidaciones->ValidarFormularioCrear($request->all())->validate();
        }else{
            $this->productoValidaciones->ValidarFormularioCrearConProveedor($request->all())->validate();
        }
        if($request->ajax()){
            $repuesta = $this->productoServicio->GuardarProducto($request);
            if($repuesta == true){
                $idEmpreesa = Auth::user()->Sede->Empresa->id;
                $productos = $this->productoServicio->ObtenerProductoPorEmpresaYProveedor($idEmpreesa);
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
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $productos = $this->productoServicio->ObtenerProductoPorEmpresaYProveedor($idEmpreesa);
        $view = View::make('MInventario/Producto/listaProductos')->with('listProductos',$productos);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Producto/listaProductos');
    }

    //Metodo que me retornar una lista de productosPorProveedor filtrado por el id o pk del producto
    public function ObtenerProductoProveedor($idProducto){
        return response()->json($this->productoServicio->ObtenerProductoProveedorIdproducto($idProducto));
    }
}