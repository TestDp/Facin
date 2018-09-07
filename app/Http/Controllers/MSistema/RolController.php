<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 5/09/2018
 * Time: 1:33 PM
 */

namespace App\Http\Controllers\MSistema;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MSistema\RolServicio;
use Facin\Validaciones\MSistema\RolValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class RolController extends Controller
{
    protected  $rolServicio;
    protected  $rolValidaciones;
    public function __construct(RolServicio $rolServicio, RolValidaciones $rolValidaciones){
        $this->rolServicio = $rolServicio;
        $this->rolValidaciones = $rolValidaciones;
    }

    //Metodo para cargar  la vista de crear un rol
    public function CrearRol(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $recursos = $request->user()->ListaRecursos();
        $view = View::make('MSistema/Rol/crearRol')->with('listRecursos',$recursos);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/Rol/crearRol');
    }

    //Metodo para guarda la informacion del rol
    public  function GuardarRol(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->rolValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $rol = $request->all();
            $idEmpreesa = Auth::user()->Sede->Empresa->id;
            $rol['Empresa_id'] = $idEmpreesa;
            $repuesta = $this->rolServicio->GuardarRol($rol);
            if($repuesta == true){
                $roles = $this->rolServicio->ObtenerListaRoles($idEmpreesa);
                $view = View::make('MSistema/Rol/listaRoles')->with('listRoles',$roles);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->rolServicio->GuardarRol($rol);
            }
        }else return view('MInventario/Categoria/listaCategorias');
    }

    //Metodo para obtener todos  los roles
    public  function ObtenerRoles(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $roles = $this->rolServicio->ObtenerListaRoles($idEmpreesa);
        $view = View::make('MSistema/Rol/listaRoles')->with('listRoles',$roles);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/Rol/listaRoles');
    }
}