<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/08/2018
 * Time: 1:13 PM
 */

namespace App\Http\Controllers\MSistema;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MSistema\UnidadDeMedidaServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class UnidadDeMedidaController extends  Controller
{

    protected  $unidadDeMedidaServicio;
    public function __construct(UnidadDeMedidaServicio $unidadDeMedidaServicio){
        $this->middleware('auth');
        $this->unidadDeMedidaServicio = $unidadDeMedidaServicio;
    }

    //Metodo para cargar  la vista de crear una unidad de medida
    public function CrearUnidad(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin']);
        $view = View::make('MSistema/UnidadDeMedida/crearUnidad');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/UnidadDeMedida/crearUnidad');
    }

    //Metodo para guardar la unidad
    public  function GuardarUnidad(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin']);
        if($request->ajax()){
            $repuesta = $this->unidadDeMedidaServicio->GuardarUnidad($request);
            if($repuesta == true){
                $unidades = $this->unidadDeMedidaServicio->ObtenerListaUnidades();
                $view = View::make('MSistema/UnidadDeMedida/listaUnidades')->with('listUnidades',$unidades);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->unidadDeMedidaServicio->GuardarUnidad($request);
            }
        }else return view('MSistema/UnidadDeMedida/listaUnidades');
    }

    //Metodo para obtener toda  la lista de unidades de medida del producto
    public  function ObtenerUnidades(Request $request){
        $request->user()->authorizeRoles(['SuperAdmin']);
        $unidades = $this->unidadDeMedidaServicio->ObtenerListaUnidades();
        $view = View::make('MSistema/UnidadDeMedida/listaUnidades')->with('listUnidades',$unidades);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/UnidadDeMedida/listaUnidades');
    }
}