<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 30/10/2018
 * Time: 1:06 PM
 */

namespace Facin\Negocio\Logica\MFacturacion;


use Facin\Datos\Modelos\MFacturacion\Factura;
use Facin\Datos\Repositorio\MCliente\ClienteRepositorio;
use Facin\Datos\Repositorio\MFacturacion\FacturaRepositorio;
use Facin\Negocio\Logica\MInventario\ProductoServicio;

class FacturaServicio
{
    protected $facturaRepositorio;
    protected $clienteRepositorio;
    protected $productoServicio;
    public function __construct(FacturaRepositorio $facturaRepositorio,ClienteRepositorio $clienteRepositorio,ProductoServicio $productoServicio){
        $this->facturaRepositorio = $facturaRepositorio;
        $this->clienteRepositorio = $clienteRepositorio;
        $this->productoServicio = $productoServicio;
    }

    public  function CrearFacutra($idEmpreesa,$idVendedor){
        $pedido= new Factura();
        $pedido->user_id = $idVendedor;
        $pedido->EstadoFactura_id = 1;// "1" es el estado de la factura que es pedido o factura en proceso.
        $pedido->TipoDeFactura_id = 1;// el tipo de factura se debe validar con que sentido se hace
        $pedido->CantidadTotal = 0;// al crear un pedidose crea sin productos por lo cual es cero
        $pedido->VentaTotal = 0;// al crear un pedido se crea sin productos por lo cual es cero
        $pedido->DescuentoTotal = 0;// al crear un pedidose crea sin productos por lo cual es cero
        $pedido->Cliente_id = $this->clienteRepositorio->ObtenerPrimerClientesXEmpresa($idEmpreesa)->id;
        return $this->facturaRepositorio->CrearFacutra($pedido);
    }

    public function ObtenerFactura($idFactura){
        return  $this->facturaRepositorio->ObtenerFactura($idFactura);
    }

    public function ObtenerListaPedidosXSedeXEstados($idSede,$idEstado){
        return $this->facturaRepositorio->ListaPedidosXSedeXEstados($idSede,$idEstado);
    }

    public function AgregarProductosPedido($idFactura,$idProducto,$cantidad){
        $proConInvenTtal = $this->productoServicio->ObtenerProdConInvenTotalTodoTipo($idProducto);
        if($proConInvenTtal->Cantidad >= $cantidad ){
            return $this->facturaRepositorio->AgregarProductosPedido($idFactura,$idProducto,$cantidad);
        }else{
            return  $proConInvenTtal;
        }

    }

    public function ConfirmarProductosPedido($arrayDataProductos){
        return $this->facturaRepositorio->GuardarListaProductosPedido($arrayDataProductos);
    }

    public function ObtenerListaProductosXPedido($idFactura){
        return $this->facturaRepositorio->ObtenerListaProductosXPedido($idFactura);
    }

    public function ObtenerListaMediosDePagos()
    {
        return $this->facturaRepositorio->ObtenerListaMediosDePagos();
    }

    public function PagarPedido($arrayDataPagoPedido){
        return $this->facturaRepositorio->PagarPedido($arrayDataPagoPedido);
    }

    public function ObtenerDetallePagoFactura($idFactura){
        return $this->facturaRepositorio->ObtenerDetallePagoFactura($idFactura);
    }

    public function  CambiarEstadoFactura($idFactura,$idEstado){
        return $this->facturaRepositorio->CambiarEstadoFactura($idFactura,$idEstado);
    }

    public function  GuardarComentario($idFactura,$comentario){
        return $this->facturaRepositorio->GuardarComentario($idFactura,$comentario);
    }

}