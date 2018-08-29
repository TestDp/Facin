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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class InventarioController extends  Controller
{


    protected  $productoServicio;
    protected  $proveedorServicio;
    protected  $inventarioServicio;

    public function __construct(ProveedorServicio $proveedorServicio,ProductoServicio $productoServicio,
                                InventarioServicio $inventarioServicio){
        $this->middleware('auth');
        $this->proveedorServicio = $proveedorServicio;
        $this->productoServicio = $productoServicio;
        $this->inventarioServicio = $inventarioServicio;
    }

    //Metodo para cargar  la vista de para acutalizar la cantidad del producto
    public function ActualizarInvetario(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $proveedores = $this->proveedorServicio->ObtenerListaProveedores($idEmpreesa);
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $view = View::make('MInventario/Inventario/actualizarInventario',
            array('listProveedores'=>$proveedores,'listProductos'=>$productos));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Inventario/actualizarInventario');
    }

    //Metodo para guarda el inventario o actualizar la cantidad de un producto por proveedor
    public  function GuardarInventario(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        if($request->ajax()){
            $repuesta = $this->inventarioServicio->GuardarInventario($request);
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
}