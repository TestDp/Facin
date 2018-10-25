<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/08/2018
 * Time: 1:13 PM
 */

namespace App\Http\Controllers\MEmpresa;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MEmpresa\UnidadDeMedidaServicio;
use Facin\Validaciones\MEmpresa\UnidadDeMedidaValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class UnidadDeMedidaController extends  Controller
{

    protected  $unidadDeMedidaServicio;
    protected  $unidadDeMedidaValidaciones;

    public function __construct(UnidadDeMedidaServicio $unidadDeMedidaServicio, UnidadDeMedidaValidaciones $unidadDeMedidaValidaciones){
        $this->middleware('auth');
        $this->unidadDeMedidaServicio = $unidadDeMedidaServicio;
        $this->unidadDeMedidaValidaciones = $unidadDeMedidaValidaciones;
    }

    //Metodo para cargar  la vista de crear una unidad de medida
    public function CrearUnidad(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $view = View::make('MEmpresa/UnidadDeMedida/crearUnidad');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MEmpresa/UnidadDeMedida/crearUnidad');
    }

    //Metodo para guardar la unidad
    public  function GuardarUnidad(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->unidadDeMedidaValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $unidadMedida= $request->all();
            $idEmpreesa = Auth::user()->Sede->Empresa->id;
            $unidadMedida['Empresa_id'] = $idEmpreesa;
            $repuesta = $this->unidadDeMedidaServicio->GuardarUnidad($unidadMedida);
            if($repuesta == true){
                $unidades = $this->unidadDeMedidaServicio->ObtenerListaUnidadesEmpresa($idEmpreesa);
                $view = View::make('MEmpresa/UnidadDeMedida/listaUnidades')->with('listUnidades',$unidades);
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
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $unidades = $this->unidadDeMedidaServicio->ObtenerListaUnidades();
        $view = View::make('MEmpresa/UnidadDeMedida/listaUnidades')->with('listUnidades',$unidades);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MEmpresa/UnidadDeMedida/listaUnidades');
    }

    //Metodo para obtener toda  la lista de unidades de medida del producto
    public  function ObtenerUnidadesEmpresa(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $unidades = $this->unidadDeMedidaServicio->ObtenerListaUnidadesEmpresa($idEmpreesa);
        $view = View::make('MEmpresa/UnidadDeMedida/listaUnidades')->with('listUnidades',$unidades);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MEmpresa/UnidadDeMedida/listaUnidades');
    }
}