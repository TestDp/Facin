<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 25/08/2018
 * Time: 12:27 PM
 */

namespace App\Http\Controllers\MInventario;

use Facin\Negocio\Logica\MEmpresa\SedeServicio;
use Facin\Negocio\Logica\MInventario\AlmacenServicio;
use Facin\Validaciones\MInventario\AlmacenValidaciones;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class AlmacenController extends  Controller
{

    protected  $almacenServicio;
    protected  $almacenValidaciones;
    protected  $sedeServicio;

    public function __construct(AlmacenServicio $almacenServicio,AlmacenValidaciones $almacenValidaciones,SedeServicio $sedeServicio){
        $this->middleware('auth');
        $this->almacenServicio = $almacenServicio;
        $this->almacenValidaciones = $almacenValidaciones;
        $this->sedeServicio = $sedeServicio;
    }

    //Metodo para cargar  la vista de crear el almacen
    public function CrearAlmacen(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $sedes = $this->sedeServicio->ObtenerListaSedes($idEmpreesa);
        $view = View::make('MInventario/Almacen/crearAlmacen')->with('listSedes',$sedes);;
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Almacen/crearAlmacen');
    }

    //Metodo para obtener la vista de editar Almacen
    public function ObetnerVistaEditarAlmacen(Request $request,$idAlmacen)
    {
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idAlmacen,$urlinfo)[0];//se parte la url para quitarle el parametro y porder consultarla NOTA:provicional mientras se encuentra otra forma
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $sedes = $this->sedeServicio->ObtenerListaSedes($idEmpreesa);
        $almacen = $this->almacenServicio->ObtenerAlmacenXId($idAlmacen);
        $view = View::make('MInventario/Almacen/editarAlmacen',array('listSedes'=>$sedes,'almacen'=>$almacen));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Almacen/editarAlmacen');
    }
    //Metodo para guarda la categoria
    public  function GuardarAlmacen(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->almacenValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $almacen = $request->all();
            $idEmpresa = Auth::user()->Sede->Empresa->id;
            $repuesta = $this->almacenServicio->GuardarAlmacen($almacen);
            if($repuesta == true){
                $almacenes = $this->almacenServicio->ObtenerListaAlmacenXEmpresa($idEmpresa);
                $view = View::make('MInventario/Almacen/listaAlmacenes')->with('listAlmacenes',$almacenes);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->almacenServicio->GuardarAlmacen($almacen);
            }
        }else return view('MInventario/Almacen/listaAlmacenes');
    }

    //Metodo para obtener todos los almacenes
    public  function ObtenerAlmacenes(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpresa = Auth::user()->Sede->Empresa->id;
        $almacenes = $this->almacenServicio->ObtenerListaAlmacenXEmpresa($idEmpresa);
        $view = View::make('MInventario/Almacen/listaAlmacenes')->with('listAlmacenes',$almacenes);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Almacen/listaAlmacenes');
    }
}