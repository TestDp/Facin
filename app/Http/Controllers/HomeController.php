<?php

namespace App\Http\Controllers;

use Facin\Negocio\Logica\MFacturacion\FacturaServicio;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Array_;

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
    public function index()
    {
        $idSede = Auth::user()->Sede->id;
        $listaPedidosEnProceso = $this->facturaServicio->ObtenerListaPedidosEnProcesoXSede($idSede);

        return view('home',Array('listPedidos'=>$listaPedidosEnProceso));
    }
}
