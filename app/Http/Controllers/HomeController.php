<?php

namespace App\Http\Controllers;

use Facin\Negocio\Logica\MFacturacion\FacturaServicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    protected $facturaServicio;
    public function __construct( FacturaServicio $facturaServicio)
    {
        $this->middleware('auth');
        $this->facturaServicio = $facturaServicio;
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $idSede = Auth::user()->Sede->id;
        $listaPedidosEnProceso = $this->facturaServicio->ObtenerListaPedidosXSedeXEstados($idSede,1);//1 es el id del estado en proceso
        if($request->ajax()){
                return view('MFacturacion/Factura/datosPagFacturas', ['listPedidos' => $listaPedidosEnProceso])->render();
        }
        return view('home',Array('listPedidos'=>$listaPedidosEnProceso));
    }
}
