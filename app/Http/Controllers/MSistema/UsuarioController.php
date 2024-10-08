<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 6/09/2018
 * Time: 3:28 PM
 */

namespace App\Http\Controllers\MSistema;


use App\Http\Controllers\Controller;
use App\User;
use Facin\Datos\Modelos\MSistema\Rol_Por_Usuario;
use Facin\Negocio\Logica\MEmpresa\SedeServicio;
use Facin\Negocio\Logica\MSistema\RolServicio;
use Facin\Negocio\Logica\MSistema\UsuarioServicio;
use Facin\Validaciones\MSistema\UsuarioValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsuarioController extends  Controller
{

    protected $usuarioServicio;
    protected $sedeServicio;
    protected $rolServicio;
    protected $usuarioValidaciones;

    public function __construct(UsuarioServicio $usuarioServicio, SedeServicio $sedeServicio, RolServicio $rolServicio,
                                UsuarioValidaciones $usuarioValidaciones){
        $this->middleware('auth');
        $this->usuarioServicio = $usuarioServicio;
        $this->sedeServicio = $sedeServicio;
        $this->rolServicio = $rolServicio;
        $this->usuarioValidaciones = $usuarioValidaciones;
    }

    //Metodo para cargar  la vista de crear un usuario
    public function CrearUsuarioEmpresa(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $roles = $this->rolServicio->ObtenerListaRoles($idEmpreesa);
        $sedes = $this->sedeServicio->ObtenerListaSedes($idEmpreesa);
        $view = View::make('MSistema/Usuario/crearUsuario',
            array('listRoles'=>$roles,'listSedes'=>$sedes));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/Usuario/crearUsuario');
    }

    //Metodo para cargar  la vista de editar un usuario
    public function EditarUsuarioEmpresa(Request $request, $idUsuario)
    {
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idUsuario,$urlinfo)[0];//se parte la url para quitarle el parametro y porder consultarla NOTA:provicional mientras se encuentra otra forma
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $usuario = $this->usuarioServicio->ObtenerUsuario($idUsuario);
        $sedes = $this->sedeServicio->ObtenerListaSedes($idEmpreesa);
        $roles = $this->rolServicio->ObtenerListaRoles($idEmpreesa);
        $rolesUsuario = $this->rolServicio->ObtenerRolesUsuario($idUsuario);
        $view = View::make('MSistema/Usuario/editarUsuario',
            array('usuario'=>$usuario,'listSedes'=>$sedes,'listRoles'=>$roles,'rolesUsuario'=>$rolesUsuario));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/Usuario/editarUsuario');
    }

    //Metodo para crear un usuario desde el perfil de una empresa
    public function GuardarUsuarioEmpresa(Request $request)    {

        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->usuarioValidaciones->ValidarFormularioCrear($request->all())->validate();
        $this->usuarioServicio->GuardarUsuario($request->all());
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $idUsuario = Auth::user()->id;
        $usuarios = $this->usuarioServicio->ObtenerListaUsuarios($idEmpreesa,$idUsuario);
        $view = View::make('MSistema/Usuario/listaUsuarios')->with('listUsuarios',$usuarios);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/Usuario/listaUsuarios');
    }

    //Metodo para modificar el usuario desde el perfil de una empresa
    public function ModificarUsuarioEmpresa(Request $request)    {

        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->usuarioValidaciones->ValidarFormularioEditar($request->all())->validate();
        $this->usuarioServicio->EditarUsuario($request->all());
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $idUsuario = Auth::user()->id;
        $usuarios = $this->usuarioServicio->ObtenerListaUsuarios($idEmpreesa,$idUsuario);
        $view = View::make('MSistema/Usuario/listaUsuarios')->with('listUsuarios',$usuarios);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/Usuario/listaUsuarios');
    }

    //Metodo para obtener todos  los usuarios por empresa
    public  function ObtenerUsuarios(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $idUsuario = Auth::user()->id;
        $usuarios = $this->usuarioServicio->ObtenerListaUsuarios($idEmpreesa,$idUsuario);
        $view = View::make('MSistema/Usuario/listaUsuarios')->with('listUsuarios',$usuarios);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/Usuario/listaUsuarios');
    }

    //Funcion para verificar el correo del usuario registrado
    public function verifarCorreo($code)
    {
        $user = User::where('CodigoConfirmacion', $code)->first();

        if (! $user)
            return redirect('/');

        $user->CorreoConfirmado = true;
        $user->CodigoConfirmacion = null;
        $user->save();

        return redirect('/home')->with('notification', 'Has confirmado correctamente tu correo!');
    }

    public function CambiarContrasenaUsuario(Request $request){
        $urlinfo= $request->getPathInfo();
         $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->usuarioValidaciones->ValidarFormularioContrasena($request->all())->validate();
        return $this->usuarioServicio->CambiarContrasenaUsuario($request->all());

    }
}