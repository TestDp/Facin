<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 29/08/2018
 * Time: 2:15 PM
 */

namespace App\Http\Controllers\MInventario;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MInventario\InventarioServicio;
use Facin\Negocio\Logica\MInventario\ProductoServicio;
use Facin\Negocio\Logica\MInventario\ProveedorServicio;
use Facin\Validaciones\MInventario\InventarioValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class InventarioController extends  Controller
{


    protected  $productoServicio;
    protected  $proveedorServicio;
    protected  $inventarioServicio;
    protected  $inventarioValidaciones;

    public function __construct(ProveedorServicio $proveedorServicio,ProductoServicio $productoServicio,
                                InventarioServicio $inventarioServicio,InventarioValidaciones $inventarioValidaciones){
        $this->middleware('auth');
        $this->proveedorServicio = $proveedorServicio;
        $this->productoServicio = $productoServicio;
        $this->inventarioServicio = $inventarioServicio;
        $this->inventarioValidaciones = $inventarioValidaciones;
    }

    //Metodo para cargar  la vista de para acutalizar la cantidad del producto
    public function ActualizarInvetario(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $view = View::make('MInventario/Inventario/actualizarInventario',
            array('listProductos'=>$productos));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Inventario/actualizarInventario');
    }

    //Metodo para guarda el inventario o ajustar la cantidad de un producto por proveedor
    public  function GuardarInventario(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->inventarioValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $repuesta = $this->inventarioServicio->GuardarInventario($request);
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
}