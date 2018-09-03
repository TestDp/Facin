<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 24/08/2018
 * Time: 9:53 PM
 */

namespace App\Http\Controllers\MInventario;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MInventario\CategoriaServicio;
use Facin\Validaciones\MInventario\CategoriaValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;


class CategoriaController extends  Controller
{
    protected  $categoriaServicio;
    protected  $categoriaValidaciones;
    public function __construct(CategoriaServicio $categoriaServicio,CategoriaValidaciones $categoriaValidaciones){
        $this->middleware('auth');
        $this->categoriaServicio = $categoriaServicio;
        $this->categoriaValidaciones = $categoriaValidaciones;
    }

    //Metodo para cargar  la vista de crear categoria
    public function CrearCategoria(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $view = View::make('MInventario/Categoria/crearCategoria');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Categoria/crearCategoria');
    }

    //Metodo para guarda la categoria
    public  function GuardarCategoria(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->categoriaValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $categoria = $request->all();
            $idEmpreesa = Auth::user()->Sede->Empresa->id;
            $categoria['Empresa_id'] = $idEmpreesa;
            $repuesta = $this->categoriaServicio->GuardarCategoria($categoria);
            if($repuesta == true){
                $categorias = $this->categoriaServicio->ObtenerListaCategorias($idEmpreesa);
                $view = View::make('MInventario/Categoria/listaCategorias')->with('listCategorias',$categorias);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->proveedorServicio->GuardarProveedor($request);
            }
        }else return view('MInventario/Categoria/listaCategorias');
    }

    //Metodo para obtener toda  las categorias
    public  function ObtenerCategorias(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $categorias = $this->categoriaServicio->ObtenerListaCategorias($idEmpreesa);
        $view = View::make('MInventario/Categoria/listaCategorias')->with('listCategorias',$categorias);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Categoria/listaCategorias');
    }


}