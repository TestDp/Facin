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

    public function EditarFactura(Request $request,$idFactura){
        $urlinfo= $request->getPathInfo();
        $urlinfo = explode('/'.$idFactura,$urlinfo)[0];
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $Pedido =  $this->facturaServicio->ObtenerFactura($idFactura);
        $productos = $this->productoServicio->ObtenerListaProductoPorEmpresa($idEmpreesa);
        $productosXPedido = $this->facturaServicio->ObtenerListaProductosXPedido($idFactura);
        $nombreVendedor = Auth::user()->name .' '. Auth::user()->last_name;
        $view = View::make('MFacturacion/Factura/editarProductosPedido',array('listProductos'=>$productos,
            'nombreVendedor'=>$nombreVendedor,'pedido'=>$Pedido,'productosXPedido'=>$productosXPedido));
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
                // $view = View::make('MFacturacion/Factura/datosPagFacturas',array('listPedidos'=>$listaPedidosEnProceso));
            }else{
                $view = View::make('MFacturacion/Factura/listaPedidos',array('listPedidos'=>$listaPedidosEnProceso));
            }
            $sections = $view->renderSections();
            return Response::json($sections['content']);
        }else return  view('MFacturacion/Factura/listaPedidos',['listPedidos'=>$listaPedidosEnProceso]);
    }

    public function ObtenerListaMediosDePagos(Request $request){

        $keyCache = "mediosPagos";
        $mediosDePago = Cache::rememberForever($keyCache,function (){
            return $this->facturaServicio->ObtenerListaMediosDePagos();
        });
        return $mediosDePago;

       // return $this->facturaServicio->ObtenerListaMediosDePagos();
    }

    public function PagarPedido(Request $request){
        $data = json_decode($_POST['array']);
        $nombre_impresora = "facintest";
        $connector = new WindowsPrintConnector($nombre_impresora);
        $printer = new Printer($connector);
        /*
            Imprimimos un mensaje. Podemos usar
            el salto de línea o llamar muchas
            veces a $printer->text()
        */
        $printer->text("Hola mundo \nfacin.com");

        /*
            Hacemos que el papel salga. Es como
            dejar muchos saltos de línea sin escribir nada
        */
        $printer->feed();

        /*
            Cortamos el papel. Si nuestra impresora
            no tiene soporte para ello, no generará
            ningún error
        */
        $printer->cut();

        /*
            Por medio de la impresora mandamos un pulso.
            Esto es útil cuando la tenemos conectada
            por ejemplo a un cajón
        */
        $printer->pulse();

        /*
            Para imprimir realmente, tenemos que "cerrar"
            la conexión con la impresora. Recuerda incluir esto al final de todos los archivos
        */
        $printer->close();
        return $this->facturaServicio->PagarPedido($data);
    }
}