<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 5/09/2018
 * Time: 9:02 AM
 */

namespace App\Http\Controllers\MEmpresa;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MEmpresa\SedeServicio;
use Facin\Validaciones\MEmpresa\SedeValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class SedeController extends Controller
{
    protected  $sedeServicio;
    protected  $sedeValidaciones;

    public function __construct(SedeServicio $sedeServicio,SedeValidaciones $sedeValidaciones){
        $this->sedeServicio = $sedeServicio;
        $this->sedeValidaciones = $sedeValidaciones;
    }

    //Metodo para cargar  la vista de crear sede
    public function CrearSede(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $view = View::make('MEmpresa/Sede/crearSede');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MEmpresa/Sede/crearSede');
    }

    //Metodo para guarda la sede
    public  function GuardarSede(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->sedeValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $sede = $request->all();
            $idEmpreesa = Auth::user()->Sede->Empresa->id;
            $sede['Empresa_id'] = $idEmpreesa;
            $repuesta = $this->sedeServicio->GuardarSede($sede);
            if($repuesta == true){
                $sedes = $this->sedeServicio->ObtenerListaSedes($idEmpreesa);
                $view = View::make('MEmpresa/Sede/listaSedes')->with('listSedes',$sedes);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->proveedorServicio->GuardarProveedor($request);
            }
        }else return view('MEmpresa/Sede/listaSedes');
    }

    //Metodo para obtener toda  la lista de sede de la empresa
    public  function ObtenerSedes(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $sedes = $this->sedeServicio->ObtenerListaSedes($idEmpreesa);
        $view = View::make('MEmpresa/Sede/listaSedes')->with('listSedes',$sedes);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MEmpresa/Sede/listaSedes');
    }
}