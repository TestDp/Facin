<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 30/10/2018
 * Time: 1:04 PM
 */

namespace Facin\Datos\Repositorio\MFacturacion;

use Facin\Datos\Modelos\MFacturacion\Detalle;
use Facin\Datos\Modelos\MFacturacion\Factura;
use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Facin\Datos\Modelos\MFacturacion\MedioDePago;
use Facin\Datos\Modelos\MFacturacion\MedioDePagoXFactura;
use Facin\Datos\Modelos\MInventario\Producto;
use Facin\Datos\Repositorio\MInventario\ProductoRepositorio;
use Illuminate\Support\Facades\DB;

class FacturaRepositorio
{

    protected  $productoRepositorio;
    public function __construct(ProductoRepositorio $productoRepositorio){
        $this->productoRepositorio = $productoRepositorio;
    }

    public  function CrearFacutra($pedido)
    {
        DB::beginTransaction();
        try {
            $pedido->save();
            DB::commit();
            $pedido->EstadoFactura;
            $pedido->Cliente;
            return $pedido;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public function ObtenerFactura($idFactura){
        $factura =  Factura::find($idFactura);
        return $factura;
    }
    //retorna una lista de pedidos(Facturas) filtrados por sede y estado
    public function ListaPedidosXSedeXEstados($idSede,$idEstado)
    {
        $pedidos = DB::table('Tbl_Facturas')
            ->join('users', 'users.id', '=', 'Tbl_Facturas.user_id')
            ->join('Tbl_Sedes', 'Tbl_Sedes.id', '=', 'users.Sede_id')
            ->join('Tbl_Estados_Facturas', 'Tbl_Estados_Facturas.id', '=', 'Tbl_Facturas.EstadoFactura_id')
            ->join('Tbl_Clientes', 'Tbl_Clientes.id', '=', 'Tbl_Facturas.Cliente_id')
            ->select('Tbl_Facturas.*','Tbl_Clientes.Nombre','Tbl_Clientes.Apellidos','Tbl_Estados_Facturas.Nombre as nombreEstado')
            ->where('Tbl_Sedes.id', '=', $idSede)
            ->where('Tbl_Facturas.EstadoFactura_id', '=', $idEstado)
            //->orderBy('Tbl_Facturas.id')
            ->latest()
            ->paginate(10);
        return $pedidos;
    }

    //Function para guardar la lista de productos del pedido(factura)
    public function GuardarListaProductosPedido($arrayDataProductos){
        DB::beginTransaction();
        try {
            $precioTotal = 0;
            $cantidadTotal = 0;
            $descuentoTotal = 0;
           if($arrayDataProductos[0]->EsEditar == 'true')// se pregunta si lo que se va a guardar es desde la vista de la edición
           {
               Detalle::where('Factura_id','=',$arrayDataProductos[0]->Factura_id)->delete();
           }
            foreach ($arrayDataProductos as $productoDetalle){
                $producto= Producto::find($productoDetalle->Producto_id);
                $esPrincipal = $this->productoRepositorio->EsProductoPrincipal($productoDetalle->Producto_id);
                if($esPrincipal)
                {
                    $cantidadDisponible =$this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoDetalle->Producto_id)->Cantidad;
                    if($cantidadDisponible < $productoDetalle->Cantidad)
                    {
                        return ["SinExistencia"=>true,"producto"=>$producto->Nombre,"cantidad"=>$cantidadDisponible];
                    }

                    $cantidadInventario = ($cantidadDisponible-$productoDetalle->Cantidad);
                    ProductoPorProveedor::where('Producto_id','=',$productoDetalle->Producto_id)->update(array('Cantidad' => $cantidadInventario));
                }
                else
                {
                    $productoPrincipalId = $this->productoRepositorio->ObtenerProductoEquivalencia($productoDetalle->Producto_id)->ProductoPrincipal_id;
                    $cantidadEquivalencia = $this->productoRepositorio->ObtenerProductoEquivalencia($productoDetalle->Producto_id)->Cantidad;
                    $cantidadDisponible =$this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoPrincipalId)->Cantidad;
                    $cantidadDisponibleEquivalente = ($productoDetalle->Cantidad * $cantidadEquivalencia);
                    if($cantidadDisponible < $cantidadDisponibleEquivalente)
                    {
                        return ["SinExistencia"=>true,"producto"=>$producto->Nombre,"cantidad"=>($cantidadDisponible/$cantidadEquivalencia)];
                    }

                    $cantidadInventario = ($cantidadDisponible - $cantidadDisponibleEquivalente);
                    ProductoPorProveedor::where('Producto_id','=',$productoPrincipalId)->update(array('Cantidad' => $cantidadInventario));
                    $cantidadDisponibleSecundario =$this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoDetalle->Producto_id)->Cantidad;
                    $cantidadInventarioSecundario = ($cantidadDisponibleSecundario-$productoDetalle->Cantidad);
                    ProductoPorProveedor::where('Producto_id','=',$productoDetalle->Producto_id)->update(array('Cantidad' => $cantidadInventarioSecundario));
                }

                $productoPedido = new Detalle();
                $productoPedido->Producto_id = $productoDetalle->Producto_id;
                $productoPedido->Factura_id = $productoDetalle->Factura_id;
                $productoPedido->Cantidad = $productoDetalle->Cantidad;
                $productoPedido->Comentario = $productoDetalle->Comentario;
                $productoPedido->Descuento = 0;
                $productoPedido ->SubTotal = $productoDetalle->Cantidad * $producto->Precio;
                $productoPedido->save();
                $precioTotal = $precioTotal + $productoPedido->SubTotal;
                $cantidadTotal = $cantidadTotal + $productoPedido->Cantidad;
                $descuentoTotal = $descuentoTotal + $productoPedido->Descuento;


            }
            DB::commit();
            Factura::where('id','=',$productoDetalle->Factura_id)->update(array('VentaTotal' => $precioTotal, 'CantidadTotal' => $cantidadTotal ));
            return ["Respuesta"=>true,"PrecioTotal"=>$precioTotal];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    //Retorna los producto del pedido(Factura)
    public function ObtenerListaProductosXPedido($idFactura){
       $productosPedido = Detalle::where('Factura_id','=',$idFactura)->get();
        foreach ($productosPedido as $productoPedido){
            $productoPedido->Producto;
        }
        return $productosPedido;
    }

    //Retonar la lista de medios de pagos
    public function ObtenerListaMediosDePagos(){
        return MedioDePago::all();
    }

    public function PagarPedido($arrayDataMediosDepago){
        DB::beginTransaction();
        try {
            foreach ($arrayDataMediosDepago as $arrayMedioDePagoXPedido){
                $medioDePagoXPedido = new MedioDePagoXFactura();
                $medioDePagoXPedido->Valor = $arrayMedioDePagoXPedido->Valor;
                $medioDePagoXPedido->Factura_id = $arrayMedioDePagoXPedido->Factura_id;
                $medioDePagoXPedido->MedioDePago_id = $arrayMedioDePagoXPedido->MedioDePago_id;
                $medioDePagoXPedido->save();
            }
            $factura =$this->ObtenerFactura($arrayDataMediosDepago[0]->Factura_id);
            $factura->EstadoFactura_id=2;//se pasa el pedido(factura) al estado de finalizada
            $factura->save();
            DB::commit();
            return ["Respuesta"=>true];
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

}