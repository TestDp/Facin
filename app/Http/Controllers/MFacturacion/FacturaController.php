<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 29/10/2018
 * Time: 11:32 AM
 */

namespace App\Http\Controllers\MFacturacion;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MCliente\ClienteServicio;
use Facin\Negocio\Logica\MFacturacion\FacturaServicio;
use Facin\Negocio\Logica\MInventario\ProductoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;

class FacturaController extends Controller
{

    protected $clienteServicio;
    protected $facturaServicio;
    protected $productoServicio;

    public function __construct(ClienteServicio $clienteServicio,FacturaServicio $facturaServicio,ProductoServicio $productoServicio){
        $this->clienteServicio = $clienteServicio;
        $this->facturaServicio = $facturaServicio;
        $this->productoServicio = $productoServicio;
    }
    public  function ObtenerFormularioCrearPedido(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $listaClientes = $this->clienteServicio->ObtenerListaClientesXEmpresa($idEmpreesa);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $view = View::make('MFacturacion/Factura/crearPedido',array('ListClientes'=>$listaClientes,'nombreVendedor'=>$nombreVendedor));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['contentFormPedido']);
        }else return  view('MFacturacion/Factura/crearPedido',['ListClientes'=>$listaClientes]);
    }

    public  function CrearFactura(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $pedido = $request->all();
        $idVendedor = Auth::user()->id;
        $Pedido =  $this->facturaServicio->CrearFacutra($pedido,$idVendedor);
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $view = View::make('MFacturacion/Factura/productosPedido',array('listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json(['vista'=>$sections['contentFormPedido'],'Pedido'=>$Pedido]);
        }else return  View::make('MFacturacion/Factura/productosPedido',array('listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'$pedido'=>$Pedido));
    }

    public function ConfirmarProductosPedido(Request $request){
        $data = json_decode($_POST['array']);
        return $this->facturaServicio->ConfirmarProductosPedido($data);
    }
}