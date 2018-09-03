<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 24/08/2018
 * Time: 9:39 AM
 */

namespace App\Http\Controllers\MSistema;

use App\Http\Controllers\Controller;
use Facin\Validaciones\MSistema\TipoDocumentoValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Facin\Negocio\Logica\MSistema\TipoDocumentoServicio;

class TipoDocumentoController extends Controller
{
    protected  $TipoDocumentoServicio;
    protected $tipoDocumentoValidaciones;
    public function __construct(TipoDocumentoServicio $TipoDocumentoServicio,TipoDocumentoValidaciones $tipoDocumentoValidaciones){
        $this->middleware('auth');
        $this->TipoDocumentoServicio = $TipoDocumentoServicio;
        $this->tipoDocumentoValidaciones = $tipoDocumentoValidaciones;
    }

    //Metodo para cargar  la vista de crear el tipo de documento
    public function CrearTipoDocumento(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $view = View::make('MSistema/TipoDocumento/crearTipoDocumento');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/TipoDocumento/crearTipoDocumento');
    }

    //Metodo para guardar el tipo de documento
    public  function GuardarTipoDocumento(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->tipoDocumentoValidaciones->ValidarFormularioCrear($request->all())->validate();
        if($request->ajax()){
            $repuesta = $this->TipoDocumentoServicio->GuardarTipoDocumento($request);
            if($repuesta == true){
                $tiposDoc = $this->TipoDocumentoServicio->ObtenerListaTipoDocumentos();
                $view = View::make('MSistema/TipoDocumento/listaDocumentos')->with('listDoc',$tiposDoc);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
            }
            else{
                return $this->TipoDocumentoServicio->GuardarTipoDocumento($request);
            }
        }else return view('MSistema/TipoDocumento/listaDocumentos');
    }

    //Metodo para obtener toda  la lista de tipos de documentos
    public  function ObtenerTiposDocumentos(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $tiposDoc = $this->TipoDocumentoServicio->ObtenerListaTipoDocumentos();
        $view = View::make('MSistema/TipoDocumento/listaDocumentos')->with('listDoc',$tiposDoc);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MSistema/TipoDocumento/listaDocumentos');
    }
}