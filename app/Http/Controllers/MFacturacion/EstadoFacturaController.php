<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/12/2018
 * Time: 12:01 PM
 */

namespace App\Http\Controllers\MFacturacion;


use App\Facin\Negocio\Logica\MFacturacion\EstadoFacturaServicio;
use App\Facin\Validaciones\MFacturacion\EstadoFacturaValidaciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;


class EstadoFacturaController extends Controller
{
    protected  $estadoFacturaServicio;
    protected $estadoFacturaValidaciones;

    public function __construct(EstadoFacturaServicio $estadoFacturaServicio,EstadoFacturaValidaciones $estadoFacturaValidaciones){
        $this->middleware('auth');
        $this->estadoFacturaServicio = $estadoFacturaServicio;
        $this->estadoFacturaValidaciones = $estadoFacturaValidaciones;
    }

    //Metodo para cargar  la vista de crear el tipo de documento
    public function ObtenerVistaCrearEstadoFactura(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $view = View::make('MFacturacion/EstadoFactura/crearEstadosFactura');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MFacturacion/EstadoFactura/crearEstadosFactura');
    }

    //Metodo para cargar  la vista de editar el tipo de documento
    public function ObtenerVistaEditarEstadoFactura(Request $request, $idEstado)
    {
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idEstado,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $estadoFactura = $this->estadoFacturaServicio->ObtenerEstadoFactura($idEstado);
        $view = View::make('MFacturacion/EstadoFactura/editarEstadosFactura', array('estadoFactura'=>$estadoFactura));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MFacturacion/EstadoFactura/crearEstadosFactura');
    }

    //Metodo para guardar el estado de factura
    public  function GuardarEstadoFactura(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->estadoFacturaValidaciones->ValidarFormularioCrear($request->all())->validate();
        $this->estadoFacturaServicio->GuardarEstadoFactura($request);
        $estadosFacturas = $this->estadoFacturaServicio->ObtenerEstadosFactura();
        if($request->ajax()){
                $view = View::make('MFacturacion/EstadoFactura/listaEstadoFactura')->with('listEstadosFac',$estadosFacturas);
                $sections = $view->renderSections();
                return Response::json($sections['content']);
        }else return view('MFacturacion/EstadoFactura/listaEstadoFactura')->with('listEstadosFac',$estadosFacturas);;
    }

    //Metodo para obtener toda  la lista de los estados de facturas
    public  function ObtenerEstadosFactura(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $estadosFacturas = $this->estadoFacturaServicio->ObtenerEstadosFactura();
        $view = View::make('MFacturacion/EstadoFactura/listaEstadoFactura')->with('listEstadosFac',$estadosFacturas);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MFacturacion/EstadoFactura/listaEstadoFactura');
    }

}