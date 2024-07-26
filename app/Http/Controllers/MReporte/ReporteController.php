<?php

namespace App\Http\Controllers\MReporte;

use App\Facin\Negocio\Logica\MReporte\ReporteServicio;
use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MFacturacion\FacturaServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;

class ReporteController extends Controller
{


    protected $facturaServicio;
    protected $reporteServicio;

    public function __construct(FacturaServicio $facturaServicio,ReporteServicio $reporteServicio){
        $this->middleware('auth');
        $this->facturaServicio = $facturaServicio;
        $this->reporteServicio = $reporteServicio;
    }

    //Metodo para cargar la vista de visualizar el informe diario
    public function ObtenerVistaInformeDiario(Request $request,$fechaFiltro)
    {
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$fechaFiltro,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpresa = Auth::user()->Sede->Empresa->id;
        $ventasXDiaXMDD = $this->reporteServicio->ReporteVentasXFecha($idEmpresa,$fechaFiltro);
        $gastosProveedorXFecha = $this->reporteServicio->ReporteGastosXFecha($idEmpresa,$fechaFiltro);
        $mediosPago = $this->facturaServicio->ObtenerListaMediosDePagos();
        $totalVenta = $ventasXDiaXMDD->sum('Total');
        $totalGasto = $gastosProveedorXFecha->sum('Total');
        $view = View::make('MReporte/cierreDiario',array('ventasXDiaXMDD'=>$ventasXDiaXMDD,
            'mediosPago' => $mediosPago,'totalVenta'=>$totalVenta,'gastosProveedorXFecha'=>$gastosProveedorXFecha,'totalGasto'=>$totalGasto));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return view('MReporte/cierreDiario');
    }

    //Metodo para cargar la vista de visualizar el informe por rango de fechas
    public function ObtenerVistaInformeXFechas(Request $request,$fechaFiltroInicial,$fechaFiltroFechaFinal)
    {
      //  $urlinfo= $request->getPathInfo();
        //$urlinfo = explode('/'.$fechaFiltroInicial,$urlinfo)[0];
        //$request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpresa = Auth::user()->Sede->Empresa->id;
        $ventasXFechasXMDD = $this->reporteServicio->ReporteVentasXRangoFechas($idEmpresa,$fechaFiltroInicial,$fechaFiltroFechaFinal);
        $gastosProveedorXFecha = $this->reporteServicio->ReporteGastosXRangoFechas($idEmpresa,$fechaFiltroInicial,$fechaFiltroFechaFinal);
        $mediosPago = $this->facturaServicio->ObtenerListaMediosDePagos();
        $totalVenta = $ventasXFechasXMDD->sum('Total');
        $totalGasto = $gastosProveedorXFecha->sum('Total');
        $view = View::make('MReporte/informeXFechas');
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json(['vista'=>$sections['content'],'ventasXfechasXMDD'=>$ventasXFechasXMDD,
                'mediosPago' => $mediosPago,'totalVenta'=>$totalVenta,'gastosProveedorXFecha'=>$gastosProveedorXFecha,'totalGasto'=>$totalGasto]);
        }else return view('MReporte/informeXFechas');
    }

    public function ObtenerVistaVentasXProducto(Request $request,$fechaFiltroInicial,$fechaFiltroFechaFinal){
        //  $urlinfo= $request->getPathInfo();
        //$urlinfo = explode('/'.$fechaFiltroInicial,$urlinfo)[0];
        //$request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpresa = Auth::user()->Sede->Empresa->id;
        $ventasXProducto = $this->reporteServicio->ObtenerVentasXProducto($idEmpresa,$fechaFiltroInicial,$fechaFiltroFechaFinal);
        $view = View::make('MReporte/ventasXProducto',array('ventasXProducto'=>$ventasXProducto));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json(['vista'=>$sections['content'],'ventasXProducto'=>$ventasXProducto]);
        }else return view('MReporte/ventasXProducto');
    }


}
