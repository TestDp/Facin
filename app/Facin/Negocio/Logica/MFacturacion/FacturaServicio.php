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

class FacturaServicio
{
    protected  $facturaRepositorio;
    public function __construct(FacturaRepositorio $facturaRepositorio){
        $this->facturaRepositorio = $facturaRepositorio;
    }

    public  function CrearFacutra($pedido,$idVendedor){
        $pedido= new Factura($pedido);
        $pedido->user_id = $idVendedor;
        $pedido->EstadoFactura_id = 1;// "1" es el estado de la factura que es pedido o factura en proceso.
        $pedido->TipoDeFactura_id = 1;// el tipo de factura se debe validar con que sentido se hace
        return $this->facturaRepositorio->CrearFacutra($pedido);
    }

    public function ObtenerListaPedidosEnProcesoXSede($idSede){
        return $this->facturaRepositorio->ListaPedidosXSedeXEstados($idSede,1);//1 es el id del estado en proceso
    }

    public function ConfirmarProductosPedido($arrayDataProductos){
        return $this->facturaRepositorio->GuardarListaProductosPedido($arrayDataProductos);
    }

}