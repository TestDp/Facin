<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/12/2018
 * Time: 2:07 PM
 */

namespace App\Http\Controllers\MFacturacion;


use App\Facin\Negocio\Logica\MFacturacion\MedioDePagoServicio;
use App\Facin\Validaciones\MFacturacion\MedioDePagoValidaciones;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class MedioDePagoController extends Controller
{

    protected  $medioDePagoServicio;
    protected  $medioDePagoValidaciones;

    public function __construct(MedioDePagoServicio$medioDePagoServicio,MedioDePagoValidaciones $medioDePagoValidaciones){
        $this->middleware('auth');
        $this->medioDePagoServicio = $medioDePagoServicio;
        $this->medioDePagoValidaciones = $medioDePagoValidaciones;
    }

    //Metodo para cargar  la vista de crear el medio de pago
    public function ObtenerVistaCrearMedioDePago(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $view = View::make('MFacturacion/MedioDePago/crearMedioDePago');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MFacturacion/MedioDePago/crearMedioDePago');
    }

    //Metodo para cargar  la vista de editar el medio de pago
    public function ObtenerVistaEditarMedioDePago(Request $request, $idMedio)
    {
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idMedio,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $medioDePago = $this->medioDePagoServicio->ObtenerMedioDePago($idMedio);
        $view = View::make('MFacturacion/MedioDePago/editarMedioDePago', array('medioDePago'=>$medioDePago));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MFacturacion/MedioDePago/crearMedioDePago');
    }

    //Metodo para guardar el medio de pago
    public  function GuardarMedioDePago(Request $request)
    {
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->medioDePagoValidaciones->ValidarFormularioCrear($request->all())->validate();
        $this->medioDePagoServicio->GuardarMedioDePago($request);
        $estadosFacturas = $this->medioDePagoServicio->ObtenerMediosDePago();
        if($request->ajax()){
            $view = View::make('MFacturacion/MedioDePago/listaMediosDePago')->with('listMediosDePago',$estadosFacturas);
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MFacturacion/MedioDePago/listaMediosDePago')->with('listMediosDePago',$estadosFacturas);
    }

    //Metodo para obtener toda  la lista de los medio de pago
    public  function ObtenerMediosDePago(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $estadosFacturas = $this->medioDePagoServicio->ObtenerMediosDePago();
        $view = View::make('MFacturacion/MedioDePago/listaMediosDePago')->with('listMediosDePago',$estadosFacturas);
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MFacturacion/MedioDePago/listaMediosDePago');
    }

}