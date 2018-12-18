<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 12/09/2018
 * Time: 1:09 PM
 */

namespace App\Http\Controllers\MSistema;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MSistema\TipoDeProductoServicio;
use Facin\Validaciones\MSistema\TipoDeProductoValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class TipoDeProductoController extends Controller
{
    protected  $tipoProductoServicio;
    protected  $tipoDeProductoValidaciones;

    public function __construct(TipoDeProductoServicio $tipoProductoServicio,TipoDeProductoValidaciones $tipoDeProductoValidaciones){
        $this->middleware('auth');
        $this->tipoProductoServicio = $tipoProductoServicio;
        $this->tipoDeProductoValidaciones = $tipoDeProductoValidaciones;
    }

    //Metodo para cargar  la vista de craar un tipo de producto
    public function CrearTipoDeProducto(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $view = View::make('MSistema/TipoDeProducto/crearTipoProducto');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/TipoDeProducto/crearTipoProducto');
    }

    //Metodo para guardar el tipo de producto
    public  function GuardarTipoProducto(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->tipoDeProductoValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $repuesta = $this->tipoProductoServicio->GuardarTipoProducto($request);
            if($repuesta == true){
                $tiposProductos = $this->tipoProductoServicio->ObtenerListaTipoProductos();
                $view = View::make('MSistema/TipoDeProducto/listaTiposProductos')->with('listTiposProductos',$tiposProductos);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->tipoProductoServicio->ObtenerListaTipoProductos($request);
            }
        }else return view('MSistema/TipoDocumento/listaDocumentos');
    }

    //Metodo para obtener toda  la lista de tipos de productos del producto
    public  function ObtenerTiposProductos(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $tiposProductos = $this->tipoProductoServicio->ObtenerListaTipoProductos();
        $view = View::make('MSistema/TipoDeProducto/listaTiposProductos')->with('listTiposProductos',$tiposProductos);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/TipoDeProducto/listaTiposProductos');
    }
}