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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class CategoriaController extends  Controller
{
    protected  $categoriaServicio;
    public function __construct(CategoriaServicio $categoriaServicio){
        $this->middleware('auth');
        $this->categoriaServicio = $categoriaServicio;
    }

    //Metodo para cargar  la vista de crear categoria
    public function CrearCategoria(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $view = View::make('MInventario/Categoria/crearCategoria');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Categoria/crearCategoria');
    }

    //Metodo para guarda la categoria
    public  function GuardarCategoria(Request $request)
    {
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
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
        $request->user()->authorizeRoles(['SuperAdmin','Admin']);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $categorias = $this->categoriaServicio->ObtenerListaCategorias($idEmpreesa);
        $view = View::make('MInventario/Categoria/listaCategorias')->with('listCategorias',$categorias);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MInventario/Categoria/listaCategorias');
    }
}