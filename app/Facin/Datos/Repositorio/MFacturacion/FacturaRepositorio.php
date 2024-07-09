<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 30/10/2018
 * Time: 1:04 PM
 */

namespace Facin\Datos\Repositorio\MFacturacion;

use App\Facin\Datos\Repositorio\MInventario\InventarioRepositorio;
use Facin\Datos\Modelos\MFacturacion\Detalle;
use Facin\Datos\Modelos\MFacturacion\Factura;
use Facin\Datos\Modelos\MFacturacion\MedioDePago;
use Facin\Datos\Modelos\MFacturacion\MedioDePagoXFactura;
use Facin\Datos\Modelos\MInventario\Producto;
use Facin\Datos\Repositorio\MInventario\ProductoRepositorio;
use Facin\Negocio\Logica\MInventario\InventarioServicio;
use Illuminate\Support\Facades\DB;


class FacturaRepositorio
{

    protected  $productoRepositorio;
    protected $inventarioServcio;
    protected  $inventarioRepositorio;
    public function __construct(ProductoRepositorio $productoRepositorio, InventarioServicio $inventarioServcio,
                                InventarioRepositorio $inventarioRepositorio){
        $this->productoRepositorio = $productoRepositorio;
        $this->inventarioServcio = $inventarioServcio;
        $this->inventarioRepositorio = $inventarioRepositorio;
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
        $factura->Cliente;
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

    public function AgregarProductosPedido($idFactura,$idProducto,$cantidad){
        DB::beginTransaction();
        try {
            $descuentoTotal = 0;
            $producto = Producto::find($idProducto);
            $detallePedido = Detalle::where('Factura_id','=',$idFactura)->where('Producto_id','=',$idProducto)->first();
            if(isset($detallePedido)){
                if( $cantidad < 0 &&  $detallePedido->Cantidad == -$cantidad){
                    $this->EliminarProductoPedido($detallePedido);
                }else{
                    $this->ActulizarProductoPedido($detallePedido,$cantidad,'',$producto->Precio);
                }
            }else{
                $this->CrearProductoPedido($idProducto,$idFactura,$cantidad,'',$producto->Precio);
            }
            $this->inventarioRepositorio->ActualizarInventarioProducto($idProducto, $cantidad);
            $factura = Factura::find($idFactura);
            $factura->CantidadTotal = $factura->CantidadTotal + $cantidad;
            $factura->VentaTotal = $factura->VentaTotal + $cantidad*$producto->Precio;
            $factura->save();
            DB::commit();
            return ["Respuesta"=>true,"PrecioTotal"=>$factura->VentaTotal];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }


    public function GuardarListaProductosPedido($arrayDataProductos){
        DB::beginTransaction();
        try {
            $precioTotal = 0;
            $cantidadTotal = 0;
            $descuentoTotal = 0;
            $detallesPedido =  Detalle::where('Factura_id','=',$arrayDataProductos[0]->Factura_id)->get();
            foreach ($arrayDataProductos as $productoDetalle){
                if($this->productoRepositorio->ObtenerProducto($productoDetalle->Producto_id)->EsCombo){
                    $producto = Producto::find($productoDetalle->Producto_id);
                    if($productoDetalle->EsEditar == 'true'){
                        $detalleProductoPedido = $detallesPedido->where('Producto_id','=',$productoDetalle->Producto_id)->first();
                        $diferenciaDetalleProducto = $productoDetalle->Cantidad - $detalleProductoPedido->Cantidad;
                        if($productoDetalle->Cantidad == 0){
                            $detallesPedidosCombo = $this->ObtenerListaProductosDetalle($productoDetalle->Producto_id,$productoDetalle->Factura_id,$detalleProductoPedido->Cantidad,$detallesPedido,$productoDetalle->EsEditar);
                            $arrayDataProductosCombo = $this->ObtenerArrayDataProductos($productoDetalle->Producto_id,$productoDetalle->Factura_id,$productoDetalle->Cantidad,$arrayDataProductos,$productoDetalle->EsEditar,$detallesPedido);
                            $this->GuardarListaProductosPedidoCombo($arrayDataProductosCombo,$detallesPedidosCombo);
                            $detalleProductoPedido->delete();
                        }else{
                            if($diferenciaDetalleProducto != 0){
                                $detallesPedidosCombo = $this->ObtenerListaProductosDetalle($productoDetalle->Producto_id,$productoDetalle->Factura_id,$detalleProductoPedido->Cantidad,$detallesPedido,$productoDetalle->EsEditar);
                                $arrayDataProductosCombo = $this->ObtenerArrayDataProductos($productoDetalle->Producto_id,$productoDetalle->Factura_id,$productoDetalle->Cantidad,$arrayDataProductos,$productoDetalle->EsEditar,$detallesPedido);
                                $tieneExistencia = $this->GuardarListaProductosPedidoCombo($arrayDataProductosCombo,$detallesPedidosCombo);
                                if($tieneExistencia['SinExistencia']){
                                    return $tieneExistencia;
                                }
                                $detalleProductoPedido->update(array('Cantidad' => $productoDetalle->Cantidad, 'Comentario' => $productoDetalle->Comentario,
                                    'Descuento' => 0, 'SubTotal' => $productoDetalle->Cantidad * $producto->Precio));
                            }
                        }
                    }else{
                        $detallesPedidosCombo = $this->ObtenerListaProductosDetalle($productoDetalle->Producto_id,$productoDetalle->Factura_id,$productoDetalle->Cantidad,$detallesPedido,$productoDetalle->EsEditar);
                        $arrayDataProductosCombo = $this->ObtenerArrayDataProductos($productoDetalle->Producto_id,$productoDetalle->Factura_id,$productoDetalle->Cantidad,$arrayDataProductos,$productoDetalle->EsEditar,$detallesPedido);
                        $tieneExistencia = $this->GuardarListaProductosPedidoCombo($arrayDataProductosCombo,$detallesPedidosCombo);
                        if($tieneExistencia['SinExistencia']){
                            return $tieneExistencia;
                        }
                        $this->CrearProductoPedido($productoDetalle,$producto->Precio);
                    }

                    $precioTotal = $precioTotal + $productoDetalle->Cantidad * $producto->Precio;
                }else{
                    $esPrincipal = $this->productoRepositorio->EsProductoPrincipal($productoDetalle->Producto_id);
                    if ($esPrincipal) {
                        $producto = Producto::find($productoDetalle->Producto_id);
                       // $cantidadDisponible = $this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoDetalle->Producto_id)->Cantidad;
                        $cantidadDisponible = $this->productoRepositorio->ObtenerProdConInventarioTotal($productoDetalle->Producto_id)->Cantidad;
                        if($productoDetalle->EsEditar == 'true') {
                            $detalleProductoPedido = $detallesPedido->where('Producto_id','=',$productoDetalle->Producto_id)->first();
                            $diferenciaDetalleProducto = $productoDetalle->Cantidad - $detalleProductoPedido->Cantidad;
                            $cantidadInventario = ($cantidadDisponible - $diferenciaDetalleProducto);
                            if($productoDetalle->Cantidad == 0){
                                //$this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoDetalle->Producto_id, $cantidadInventario);

                                $this->inventarioRepositorio->ActualizarInventarioProducto($productoDetalle->Producto_id, $diferenciaDetalleProducto);

                                $detalleProductoPedido->delete();
                            }else{
                                if ($cantidadDisponible >= $diferenciaDetalleProducto) {
                                    $detalleProductoPedido->update(array('Cantidad' => $productoDetalle->Cantidad, 'Comentario' => $productoDetalle->Comentario,
                                        'Descuento' => 0, 'SubTotal' => $productoDetalle->Cantidad * $producto->Precio));

                                    //$this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoDetalle->Producto_id, $cantidadInventario);
                                    $this->inventarioRepositorio->ActualizarInventarioProducto($productoDetalle->Producto_id, $diferenciaDetalleProducto);

                                }else{
                                    return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                                }
                            }

                        } else {
                            if ($cantidadDisponible >= $productoDetalle->Cantidad) {
                                $this->CrearProductoPedido($productoDetalle,$producto->Precio);
                                //$cantidadInventario = ($cantidadDisponible - $productoDetalle->Cantidad);
                                //$this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoDetalle->Producto_id, $cantidadInventario);

                                $this->inventarioRepositorio->ActualizarInventarioProducto($productoDetalle->Producto_id, $productoDetalle->Cantidad);

                            }else{
                                return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                            }
                        }
                        $precioTotal = $precioTotal + $productoDetalle->Cantidad * $producto->Precio;
                    }else{
                        $productoPrincipalId = $this->productoRepositorio->ObtenerProductoEquivalencia($productoDetalle->Producto_id)->ProductoPrincipal_id;
                        $producto = Producto::find($productoPrincipalId);
                        $productoSecundario = Producto::find($productoDetalle->Producto_id);
                       // $cantidadDisponible =$this->productoRepositorio->ObtenerProductoProveedorIdproducto($producto->id)->Cantidad;
                        $cantidadDisponible = $this->productoRepositorio->ObtenerProdConInventarioTotal($producto->id)->Cantidad;
                        $cantidadEquivalencia = $this->productoRepositorio->ObtenerProductoEquivalencia($productoDetalle->Producto_id)->Cantidad;
                        if($productoDetalle->EsEditar == 'true') {
                            $detalleProductoPedido = $detallesPedido->where('Producto_id','=',$productoDetalle->Producto_id)->first();
                            $diferenciaDetalleProducto = ($productoDetalle->Cantidad - $detalleProductoPedido->Cantidad)/$cantidadEquivalencia;
                            $cantidadInventario = ($cantidadDisponible - $diferenciaDetalleProducto);
                            if($productoDetalle->Cantidad == 0){
                                //$this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoPrincipalId, $cantidadInventario);

                                $this->inventarioRepositorio->ActualizarInventarioProducto($productoPrincipalId, $diferenciaDetalleProducto);

                                $detalleProductoPedido->delete();
                            }else{
                                if($cantidadDisponible >= $diferenciaDetalleProducto){
                                    $detalleProductoPedido->update(array('Cantidad' => $productoDetalle->Cantidad, 'Comentario' => $productoDetalle->Comentario,
                                        'Descuento' => 0, 'SubTotal' => $productoDetalle->Cantidad * $productoSecundario->Precio));
                                   // $this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoPrincipalId, $cantidadInventario);

                                    $this->inventarioRepositorio->ActualizarInventarioProducto($productoPrincipalId,$diferenciaDetalleProducto);


                                }else{
                                    return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                                }
                            }

                        }else{
                            if ($cantidadDisponible >= $productoDetalle->Cantidad/$cantidadEquivalencia) {
                                $this->CrearProductoPedido($productoDetalle,$productoSecundario->Precio);

                               // $cantidadInventario = $cantidadDisponible - $productoDetalle->Cantidad/$cantidadEquivalencia;
                                //$this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoPrincipalId,$cantidadInventario);

                                $this->inventarioRepositorio->ActualizarInventarioProducto($productoPrincipalId,$productoDetalle->Cantidad/$cantidadEquivalencia);
                            }else{
                                return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                            }
                        }
                        $precioTotal = $precioTotal + $productoDetalle->Cantidad * $productoSecundario->Precio;
                    }
                }

                $cantidadTotal = $cantidadTotal + $productoDetalle->Cantidad;
            }
            DB::commit();
            Factura::where('id','=',$arrayDataProductos[0]->Factura_id)->update(array('VentaTotal' => $precioTotal, 'CantidadTotal' => $cantidadTotal,
                'Comentario' =>$arrayDataProductos[0]->comentarioPedido));
            return ["Respuesta"=>true,"PrecioTotal"=>$precioTotal];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    // cuando viene un producto combo este metodo transforma los productos del combo en array para poder procesarlos
    public function ObtenerArrayDataProductos($idProductoCombo,$facturaid,$cantidadPpal,$arrayDataProductos,$esEditar,$lisDetalles){
        $prodsDelCombo = $this->productoRepositorio->ObtenerListaProductoDelComboPorProducto($idProductoCombo);
       // $listArray = collect($arrayDataProductos);
        $arrayDataProductos = [];
        foreach ($prodsDelCombo as $prodCombo){
            $productoDetallePpal = $lisDetalles->where('Producto_id','=',$prodCombo->ProductoSecundario_id)->first();
            if(isset($productoDetallePpal) && $esEditar == 'true'){
                $stdClass =  new \stdClass();
                $stdClass->Producto_id = $prodCombo->ProductoSecundario_id;
                $stdClass->Cantidad = $productoDetallePpal->Cantidad + $cantidadPpal*$prodCombo->Cantidad;
                $stdClass->Factura_id =$facturaid;
                $stdClass->Comentario = "prueba comentario";
                $stdClass->EsEditar = 'false';
                $arrayDataProductos[] = $stdClass;
            }else{

                    $stdClass =  new \stdClass();
                    $stdClass->Producto_id = $prodCombo->ProductoSecundario_id;
                    $stdClass->Cantidad =  $cantidadPpal*$prodCombo->Cantidad;
                    $stdClass->Factura_id =$facturaid;
                    $stdClass->Comentario = "prueba comentario";
                    $stdClass->EsEditar = 'false';
                    $arrayDataProductos[] = $stdClass;

            }

        }
        return $arrayDataProductos;
    }

    // cuando viene un producto combo este metodo transforma los productos del combo en una lista de productos detalles
    // o detalle de la factura
    public function ObtenerListaProductosDetalle($idProductoCombo,$facturaid,$cantidadPpal,$productosDetallePpal,$esEditar){
        $prodsDelCombo = $this->productoRepositorio->ObtenerListaProductoDelComboPorProducto($idProductoCombo);
        $detalleProductos = Collect();
        foreach ($prodsDelCombo as $prodCombo){
            $productoDetallePpal =  $productosDetallePpal->where('Producto_id','=',$prodCombo->ProductoSecundario_id)->first();
            if(isset($productoDetallePpal) || $esEditar == 'true'){
                $productoDetalle =  new Detalle();
                $productoDetalle->Cantidad = ((isset($productoDetallePpal->Cantidad)) ? $productoDetallePpal->Cantidad : 0) + $cantidadPpal*$prodCombo->Cantidad;
                $productoDetalle->Producto_id = $prodCombo->ProductoSecundario_id;
                $productoDetalle->Factura_id = $facturaid;
                $detalleProductos->add($productoDetalle);
            }

        }
        return $detalleProductos;
    }

    public function GuardarListaProductosPedidoCombo($arrayDataProductos,$detallesPedido){
        foreach ($arrayDataProductos as $productoDetalle){
            $esPrincipal = $this->productoRepositorio->EsProductoPrincipal($productoDetalle->Producto_id);
            if ($esPrincipal) {
                $producto = Producto::find($productoDetalle->Producto_id);
               // $cantidadDisponible =$this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoDetalle->Producto_id)->Cantidad
                $cantidadDisponible = $this->productoRepositorio->ObtenerProdConInventarioTotal($productoDetalle->Producto_id)->Cantidad;
                $detalleProductoPedido = $detallesPedido->where('Producto_id','=',$productoDetalle->Producto_id)->first();
                if(isset($detalleProductoPedido)) {
                    $diferenciaDetalleProducto = $productoDetalle->Cantidad - $detalleProductoPedido->Cantidad;
                    if ($cantidadDisponible >= $diferenciaDetalleProducto) {
                        $cantidadInventario = ($cantidadDisponible - $diferenciaDetalleProducto);
                       // $this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoDetalle->Producto_id, $cantidadInventario);
                        $this->inventarioRepositorio->ActualizarInventarioProducto($productoDetalle->Producto_id, $diferenciaDetalleProducto);
                    }else{
                        return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                    }
                } else {
                    if ($cantidadDisponible >= $productoDetalle->Cantidad) {
                        $cantidadInventario = ($cantidadDisponible - $productoDetalle->Cantidad);
                        //$this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoDetalle->Producto_id, $cantidadInventario);
                        $this->inventarioRepositorio->ActualizarInventarioProducto($productoDetalle->Producto_id, $productoDetalle->Cantidad);
                    }else{
                        return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                    }
                }
            }else{
                $productoPrincipalId = $this->productoRepositorio->ObtenerProductoEquivalencia($productoDetalle->Producto_id)->ProductoPrincipal_id;
                $producto = Producto::find($productoPrincipalId);
                $cantidadDisponible = $this->productoRepositorio->ObtenerProdConInventarioTotal($producto->id)->Cantidad;
                //$cantidadDisponible =$this->productoRepositorio->ObtenerProductoProveedorIdproducto($producto->id)->Cantidad;
                $cantidadEquivalencia = $this->productoRepositorio->ObtenerProductoEquivalencia($productoDetalle->Producto_id)->Cantidad;
                $detalleProductoPedido = $detallesPedido->where('Producto_id','=',$productoDetalle->Producto_id)->first();
                if(isset($detalleProductoPedido)) {
                   // $diferenciaDetalleProducto = ($productoDetalle->Cantidad- $detalleProductoPedido->Cantidad)/$cantidadEquivalencia;
                    $diferenciaDetalleProducto = ($detalleProductoPedido->Cantidad-$productoDetalle->Cantidad)/$cantidadEquivalencia;
                    if ($cantidadDisponible >= $diferenciaDetalleProducto) {
                        $cantidadInventario = ($cantidadDisponible - $diferenciaDetalleProducto);
                        //$this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoPrincipalId, $cantidadInventario);
                        $this->inventarioRepositorio->ActualizarInventarioProducto($productoPrincipalId, $diferenciaDetalleProducto);
                    }else{
                        return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                    }
                }else{
                    if ($cantidadDisponible >= $productoDetalle->Cantidad/$cantidadEquivalencia) {
                        $cantidadInventario = $cantidadDisponible - $productoDetalle->Cantidad/$cantidadEquivalencia;
                       // $this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoPrincipalId,$cantidadInventario);
                        $this->inventarioRepositorio->ActualizarInventarioProducto($productoPrincipalId,$productoDetalle->Cantidad/$cantidadEquivalencia);
                    }else{
                        return ["SinExistencia" => true, "producto" => $producto->Nombre, "cantidad" => $cantidadDisponible];
                    }

                }

            }

        }
        return ["SinExistencia" => false, "producto" => '', "cantidad" => ''];
    }

    public function CrearProductoPedido($productoId,$facturaId,$cantidad,$comentario,$precio){
        $productoPedido = new Detalle();
        $productoPedido->Producto_id = $productoId;
        $productoPedido->Factura_id = $facturaId;
        $productoPedido->Cantidad = $cantidad;
        $productoPedido->Comentario = $comentario;
        $productoPedido->Descuento = 0;
        $productoPedido ->SubTotal = $cantidad * $precio;
        $productoPedido->save();
    }

    public function ActulizarProductoPedido($detallePedido,$cantidad,$comentario,$precio){
        $detallePedido->Cantidad = $detallePedido->Cantidad + $cantidad;
        $detallePedido ->SubTotal = $detallePedido->Cantidad * $precio;
        $detallePedido->Comentario = $comentario;
        $detallePedido->save();
    }

    public function EliminarProductoPedido($detallePedido){
        $detallePedido->delete();
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
            $ajustarPago = false;
            $factura =$this->ObtenerFactura($arrayDataMediosDepago[0]->Factura_id);
            $totalMDP = Collect($arrayDataMediosDepago)->sum('Valor');
            $diferencia = 0;
            if($totalMDP > $factura->VentaTotal ){
                $diferencia = $totalMDP - $factura->VentaTotal;
                $ajustarPago = true;
            }
            foreach ($arrayDataMediosDepago as $arrayMedioDePagoXPedido){
                $medioDePagoXPedido = new MedioDePagoXFactura();
                if($arrayMedioDePagoXPedido->MedioDePago_id == 1 && $ajustarPago){
                    $medioDePagoXPedido->Valor =  $arrayMedioDePagoXPedido->Valor - $diferencia;
                    $ajustarPago = false;
                }else{
                    $medioDePagoXPedido->Valor =  $arrayMedioDePagoXPedido->Valor;
                }
                $medioDePagoXPedido->Factura_id = $arrayMedioDePagoXPedido->Factura_id;
                $medioDePagoXPedido->MedioDePago_id = $arrayMedioDePagoXPedido->MedioDePago_id;
                $medioDePagoXPedido->save();
            }
            if($ajustarPago){
                $medioDePagoXPedido = new MedioDePagoXFactura();
                $medioDePagoXPedido->Valor =  - $diferencia;
                $medioDePagoXPedido->Factura_id = $arrayMedioDePagoXPedido->Factura_id;
                $medioDePagoXPedido->MedioDePago_id = 1;
                $medioDePagoXPedido->save();
            }
            $factura->Cliente_id = $arrayDataMediosDepago[0]->clienteidPedido;
            $factura->EstadoFactura_id = 2;//se pasa el pedido(factura) al estado de finalizada
            $factura->save();
            DB::commit();
            return ["Respuesta"=>true];
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }


    public function ObtenerDetallePagoFactura($idFactura){
        $mdsxf =  MedioDePagoXFactura::where('Factura_id','=',$idFactura)->get();
        foreach ($mdsxf as $mdxf){
            $mdxf->MedioDePago; // linea para adjutar el objeto medio de pago
        }
        return $mdsxf;
    }

    public function  CambiarEstadoFactura($idFactura,$idEstado){
        DB::beginTransaction();
        try {
            $factura = Factura::find($idFactura);
            $factura->EstadoFactura_id = $idEstado;
            $factura->save();
            $this->RetonarInventarioPedidoOfac($idFactura);
            DB::commit();
            return ["Respuesta"=>true];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    private function RetonarInventarioPedidoOfac($idFactura){
        $detallesPedido = Detalle::where('Factura_id','=',$idFactura)->get();
        foreach ($detallesPedido as $detallePedido){
            $this->inventarioRepositorio->ActualizarInventarioProducto($detallePedido->Producto_id, -$detallePedido->Cantidad);
        }
    }

    public function  GuardarComentario($idFactura,$comentario){
        $factura = Factura::find($idFactura);
        $factura->Comentario = $comentario;
        $factura->save();
        return ["Respuesta"=>true];
    }

}