<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 29/10/2018
 * Time: 11:32 AM
 */

namespace App\Http\Controllers\MFacturacion;


use App\Http\Controllers\Controller;
use App\Jobs\FactElectronicamente;
use Facin\Negocio\Logica\MCliente\ClienteServicio;
use Facin\Negocio\Logica\MFacturacion\FacturaServicio;
use Facin\Negocio\Logica\MInventario\ProductoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use stdClass;


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
/*    public  function ObtenerFormularioCrearPedido(Request $request){
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
    }*/

    public  function CrearFactura(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $idVendedor = Auth::user()->id;
        $Pedido =  $this->facturaServicio->CrearFacutra($idEmpreesa,$idVendedor);
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $listaClientes = $this->clienteServicio->ObtenerListaClientesXEmpresa($idEmpreesa);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $mediosPago = $this->ObtenerListaMediosDePagos($request);
        $view = View::make('MFacturacion/Factura/productosPedido',array('listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,'ListClientes'=>$listaClientes,'mediosPago'=>$mediosPago));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json(['vista'=>$sections['contentFormPedido'],'Pedido'=>$Pedido]);
        }else return  View::make('MFacturacion/Factura/productosPedido',array('listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'$pedido'=>$Pedido,'ListClientes'=>$listaClientes,'mediosPago'=>$mediosPago,));
    }

    public function ObtenerVistaPos(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $idVendedor = Auth::user()->id;
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $listaClientes = $this->clienteServicio->ObtenerListaClientesXEmpresa($idEmpreesa);
        $mediosPago = $this->ObtenerListaMediosDePagos($request);
        if(session()->has('idPedido')){
            $idFactura = session('idPedido');
            $Pedido =  $this->facturaServicio->ObtenerFactura($idFactura);
            if($Pedido->EstadoFactura_id == 1){
                $productosXPedido = $this->facturaServicio->ObtenerListaProductosXPedido($idFactura);
            }else{
                $Pedido =  $this->facturaServicio->CrearFacutra($idEmpreesa,$idVendedor);
                session(['idPedido' => $Pedido->id]);
            }

        }else{
            $Pedido =  $this->facturaServicio->CrearFacutra($idEmpreesa,$idVendedor);
            session(['idPedido' => $Pedido->id]);
        }
        $view = View::make('MFacturacion/Factura/posPedidos',array('listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,'ListClientes'=>$listaClientes,'mediosPago'=>$mediosPago,
            'productosXPedido'=>$productosXPedido));
        if($request->ajax()){
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return  View::make('MFacturacion/Factura/posPedidos',array('nombreVendedor'=>$nombreVendedor,
            'ListClientes'=>$listaClientes,'mediosPago'=>$mediosPago,));
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

    public function AgregarProductosPedido(Request $request,$idFactura,$idProducto){
        return $this->facturaServicio->AgregarProductosPedido($idFactura,$idProducto,1);
    }

    public function AgregarProductosPedidoPos(Request $request,$idFactura,$idProducto,$cantidad){
        return $this->facturaServicio->AgregarProductosPedido($idFactura,$idProducto,$cantidad);
    }
    public function RestarProductosPedido(Request $request,$idFactura,$idProducto){
        return $this->facturaServicio->AgregarProductosPedido($idFactura,$idProducto,-1);
    }

    public function EliminarProductosPedido(Request $request,$idFactura,$idProducto,$cantidad){
        return $this->facturaServicio->AgregarProductosPedido($idFactura,$idProducto,-$cantidad);
    }

/*    public function ConfirmarProductosPedido(Request $request){
        $data = json_decode($_POST['array']);
        return $this->facturaServicio->ConfirmarProductosPedido($data);
    }*/

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
        $idFactura = $array->Factura_id;
        $Pedido =  $this->facturaServicio->ObtenerFactura($idFactura);
        $productos = $this->productoServicio->ObtenerProductoPorEmpresaYProveedor($idEmpreesa);
        $productosXPedido = $this->facturaServicio->ObtenerListaProductosXPedido($idFactura);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $detallePagoFactura = $this->facturaServicio->ObtenerDetallePagoFactura($idFactura);
        $Pedido->fechafactura = $Pedido->updated_at->setTimezone('America/Bogota')->format('Y-m-d H:i:s');
        FactElectronicamente::dispatch(json_encode(['nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,
            'productosXPedido'=>$productosXPedido,'detallePagoFactura'=>$detallePagoFactura,'empresa' => $empresa]));
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

    public function  GuardarComentario(Request $request,$idFactura,$comentario){
       /* $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idFactura,$urlinfo)[0];
        $urlinfo = explode('/'.$idFactura,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);*/
        $respuesta = $this->facturaServicio->GuardarComentario($idFactura,$comentario);
        return Response::json(['Respuesta'=>$respuesta]);
    }
}