<?php

namespace App\Http\Controllers\MInventario;

use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MInventario\ProveedorServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class ProveedorController extends Controller
{
    protected  $proveedorServicio;
    public function __construct(ProveedorServicio $proveedorServicio){
        $this->proveedorServicio = $proveedorServicio;
    }
    //Metodo para cargar retornar la vista de crear proveedor
    public function CrearProveedor(Request $request)
    {
        $view = View::make('MInventario/Proveedor/crearProveedor');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Proveedor/crearProveedor');
    }

    //Metodo para guarda el proveedor
    public  function GuardarProveedor(Request $request)
    {
        if($request->ajax()){
            $repuesta = $this->proveedorServicio->GuardarProveedor($request);
            if($repuesta == true){
                $proveedores = $this->proveedorServicio->ObtenerListaProveedores();
                $view = View::make('MInventario/Proveedor/listaProveedores')->with('listProveedores',$proveedores);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->proveedorServicio->GuardarProveedor($request);
            }
        }else return view('MInventario/Proveedor/listaProveedores');
    }

    //Metodo para obtener toda  la lista de proveedores
    public  function ObtenerProveedores(Request $request){
        $proveedores = $this->proveedorServicio->ObtenerListaProveedores();
        $view = View::make('MInventario/Proveedor/listaProveedores')->with('listProveedores',$proveedores);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Proveedor/listaProveedores');
    }
}
