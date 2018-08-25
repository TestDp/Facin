<?php

namespace App\Http\Controllers\MInventario;

use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MInventario\ProveedorServicio;
use Facin\Negocio\Logica\MSistema\TipoDocumentoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    protected  $proveedorServicio;
    protected  $TipoDocumentoServicio;
    public function __construct(ProveedorServicio $proveedorServicio,TipoDocumentoServicio $TipoDocumentoServicio){
        $this->middleware('auth');
        $this->proveedorServicio = $proveedorServicio;
        $this->TipoDocumentoServicio = $TipoDocumentoServicio;
    }
    //Metodo para cargar retornar la vista de crear proveedor
    public function CrearProveedor(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $tiposDoc = $this->TipoDocumentoServicio->ObtenerListaTipoDocumentos();
        $view = View::make('MInventario/Proveedor/crearProveedor')->with('listDoc',$tiposDoc);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Proveedor/crearProveedor');
    }

    //Metodo para guarda el proveedor
    public  function GuardarProveedor(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        if($request->ajax()){
            $proveedor= $request->all();
            $idEmpreesa = Auth::user()->Sede->Empresa->id;
            $proveedor['Empresa_id'] = $idEmpreesa;
            $repuesta = $this->proveedorServicio->GuardarProveedor($proveedor);
            if($repuesta == true){
                $proveedores = $this->proveedorServicio->ObtenerListaProveedores($idEmpreesa);
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
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $proveedores = $this->proveedorServicio->ObtenerListaProveedores($idEmpreesa);
        $view = View::make('MInventario/Proveedor/listaProveedores')->with('listProveedores',$proveedores);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Proveedor/listaProveedores');
    }
}