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
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;

class FacturaController extends Controller
{

    protected $clienteServicio;
    protected $facturaServicio;
    protected $productoServicio;

    public function __construct(ClienteServicio $clienteServicio,FacturaServicio $facturaServicio,ProductoServicio $productoServicio){
        $this->middleware('auth');
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
        $Pedido =  $this->facturaServicio->CrearFacutra($idEmpreesa,$idVendedor);
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

    public function EditarFactura(Request $request,$idFactura){
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idFactura,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $Pedido =  $this->facturaServicio->ObtenerFactura($idFactura);
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $productosXPedido = $this->facturaServicio->ObtenerListaProductosXPedido($idFactura);
        $mediosPago = $this->ObtenerListaMediosDePagos($request);
        $listaClientes = $this->clienteServicio->ObtenerListaClientesXEmpresa($idEmpreesa);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        if($Pedido->EstadoFactura_id == 1){//1:factura en proceso y 2 factura finalizada
            $view = View::make('MFacturacion/Factura/editarProductosPedido',array('listProductos'=>$productos,
                'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,'productosXPedido'=>$productosXPedido,
                'mediosPago'=>$mediosPago,'ListClientes'=>$listaClientes));
        }else{
            $detallePagoFactura = $this->facturaServicio->ObtenerDetallePagoFactura($idFactura);
           // $mediosPago = $this->facturaServicio->ObtenerListaMediosDePagos();
            $view = View::make('MFacturacion/Factura/listaProductosPedido',array('listProductos'=>$productos,
                'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,
                'productosXPedido'=>$productosXPedido,'detallePagoFactura'=>$detallePagoFactura,'mediosPago' => $mediosPago));
        }

        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json(['vista'=>$sections['contentFormPedido'],'Pedido'=>$Pedido]);
        }else return  View::make('MFacturacion/Factura/editarProductosPedido',array('listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'$pedido'=>$Pedido,'productosXPedido'=>$productosXPedido));
    }

    public function ConfirmarProductosPedido(Request $request){
        $data = json_decode($_POST['array']);
        return $this->facturaServicio->ConfirmarProductosPedido($data);
    }
    //idEstado: 2-> finalizado, 1->En proceso
    public function getVistaListaPedidos(Request $request,$idEstado){
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idEstado,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idSede = Auth::user()->Sede->id;
        $listaPedidosEnProceso = $this->facturaServicio->ObtenerListaPedidosXSedeXEstados($idSede,$idEstado);
        if($request->ajax()){
            if(isset($request['page']))
            {
                return view('MFacturacion/Factura/datosPagFacturas', ['listPedidos' => $listaPedidosEnProceso])->render();
            }else{
                switch ($idEstado) {
                    case 1:// en proceso
                        $view = view('MFacturacion/Factura/listaPedidos',['listPedidos'=>$listaPedidosEnProceso]);
                        break;
                    case 2:// finalizado
                        $view = View::make('MFacturacion/Factura/pedidosFinalizados',array('listPedidos'=>$listaPedidosEnProceso));
                        break;
                    case 3:// eliminado
                        $view = View::make('MFacturacion/Factura/pedidosEliminados',array('listPedidos'=>$listaPedidosEnProceso));
                        break;
                    case 4:// Anulados
                        $view = View::make('MFacturacion/Factura/pedidosAnulados',array('listPedidos'=>$listaPedidosEnProceso));
                        break;
                }
                   // $view =($idEstado == 1)? view('MFacturacion/Factura/listaPedidos',['listPedidos'=>$listaPedidosEnProceso]):View::make('MFacturacion/Factura/pedidosFinalizados',array('listPedidos'=>$listaPedidosEnProceso));
            }
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else{
              return  ($idEstado == 1)? view('MFacturacion/Factura/listaPedidos',['listPedidos'=>$listaPedidosEnProceso]):View::make('MFacturacion/Factura/pedidosFinalizados',array('listPedidos'=>$listaPedidosEnProceso));
        }
    }

    public function ObtenerListaMediosDePagos(Request $request){
        $keyCache = "mediosPagos";
        $mediosDePago = Cache::rememberForever($keyCache,function (){
            return $this->facturaServicio->ObtenerListaMediosDePagos();
        });
        return $mediosDePago;
    }
    public function PagarPedido(Request $request){
        $array = json_decode($_POST['array']);
        $respuesta = $this->facturaServicio->PagarPedido($array);
        $empresa = Auth::user()->Sede->Empresa;
        $idEmpreesa = $empresa->id;
        $idFactura = $array[0]->Factura_id;
        $Pedido =  $this->facturaServicio->ObtenerFactura($idFactura);
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $productosXPedido = $this->facturaServicio->ObtenerListaProductosXPedido($idFactura);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $detallePagoFactura = $this->facturaServicio->ObtenerDetallePagoFactura($idFactura);
        return Response::json(['Respuesta'=>$respuesta,'listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,
            'productosXPedido'=>$productosXPedido,'detallePagoFactura'=>$detallePagoFactura,'empresa' => $empresa]);
    }
    public function ImprimirFactura(Request $request, $idFactura){
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idFactura,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $empresa = Auth::user()->Sede->Empresa;
        $idEmpreesa = $empresa->id;
        $Pedido =  $this->facturaServicio->ObtenerFactura($idFactura);
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $productosXPedido = $this->facturaServicio->ObtenerListaProductosXPedido($idFactura);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $detallePagoFactura = $this->facturaServicio->ObtenerDetallePagoFactura($idFactura);
        return Response::json(['listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,
            'productosXPedido'=>$productosXPedido,'detallePagoFactura'=>$detallePagoFactura,'empresa' => $empresa]);
    }

    public function  CambiarEstadoFactura(Request $request,$idFactura,$idEstado){
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idFactura,$urlinfo)[0];
        $urlinfo = explode('/'.$idFactura,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $respuesta = $this->facturaServicio->CambiarEstadoFactura($idFactura,$idEstado);
        return Response::json(['Respuesta'=>$respuesta]);
    }
}