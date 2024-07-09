<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 29/08/2018
 * Time: 2:21 PM
 */

namespace Facin\Negocio\Logica\MInventario;


use App\Facin\Datos\Repositorio\MInventario\InventarioRepositorio;
use Facin\Datos\Modelos\MInventario\PrecioDeCompra;
use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Facin\Datos\Repositorio\MInventario\ProductoRepositorio;

class InventarioServicio
{
    protected  $inventarioRepositorio;
    protected $productoRepositorio;

    public function __construct(InventarioRepositorio $inventarioRepositorio,ProductoRepositorio $productoRepositorio){
        $this->inventarioRepositorio = $inventarioRepositorio;
        $this->productoRepositorio = $productoRepositorio;
    }

    public  function GuardarInventario($request){
        $precioDeCompra = new PrecioDeCompra($request->all());
        $productoXProveedor = $this->productoRepositorio->ObtenerProductoProveedorIdproducto($request->Producto_id);
        $producto = $this->productoRepositorio->ObtenerProducto($request->Producto_id);
        $productoXProveedor->Cantidad = $productoXProveedor->Cantidad + $request->Cantidad;
        $precioDeCompra->ProductoPorProveedor_id = $productoXProveedor->id;
        $producto->Precio = $request->PrecioVenta;
        $this->inventarioRepositorio->ActualizarInventarioProducto($request->Producto_id,$productoXProveedor->Cantidad);
        return $this->inventarioRepositorio->GuardarInventario($precioDeCompra,$productoXProveedor,$producto);
    }

    public  function GuardarCompra($request){
        try {
                $cantidadProductos = count($request['Cantidad']);
                for($i=0;$i<$cantidadProductos;$i++){
                    $productoXProveedor = $this->productoRepositorio->ObtenerProductoXProveedor($request['Producto_id'][$i],$request['Proveedor_id']);
                    $precioDeCompra = new PrecioDeCompra();
                    $precioDeCompra->Cantidad = $request['Cantidad'][$i];
                    $precioDeCompra->Precio = $request['PrecioCompra'][$i];
                    $precioDeCompra->NumFacturaProvedor = $request['NumFacturaProvedor'];
                    $precioDeCompra->Comentarios = $request['Comentarios'];
                    if(isset($productoXProveedor)){
                        $productoXProveedor->Cantidad = $productoXProveedor->Cantidad + $request['Cantidad'][$i];
                    }else{
                        $productoXProveedor = new ProductoPorProveedor();
                        $productoXProveedor->Cantidad = $request['Cantidad'][$i];
                        $productoXProveedor->Producto_id = $request['Producto_id'][$i];
                        $productoXProveedor->Proveedor_id = $request['Proveedor_id'];
                        $productoXProveedor->CantidadMinima = 0;
                    }
                    $producto = null;
                    if(isset($request['PrecioVenta'][$i])){
                        $producto = $this->productoRepositorio->ObtenerProducto($request['Producto_id'][$i]);
                        $producto->Precio = $request['PrecioVenta'][$i];
                    }
                    $this->inventarioRepositorio->GuardarInventario($precioDeCompra,$productoXProveedor,$producto!= null ? $producto : null);
                }
            return true;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            return $error;
        }

    }


    public  function ObtenerCompras($idEmpresa){
        return  $this->inventarioRepositorio->ObtenerCompras($idEmpresa);
    }

    public function ConsultarCompra($idEmpresa,$fecha,$numFactura){
        return  $this->inventarioRepositorio->ConsultarCompra($idEmpresa,$fecha,$numFactura);
    }
/*    public function ActualizarProductosSecundarios($productoPrincipal, $cantidadPrincipal, $productoSecundario){

        $arrayProductosSecundarios = $this->productoRepositorio->ObtenerProductosSecundarios($productoPrincipal);

        foreach ($arrayProductosSecundarios as $productoSecunDetalle) {
            if ($productoSecundario <> $productoSecunDetalle->ProductoSecundario_id) {
                $cantidadProductoSecun = $this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoSecunDetalle->ProductoSecundario_id)->Cantidad;
                $cantidadequivalenciaSecun = $this->productoRepositorio->ObtenerProductoEquivalencia($productoSecunDetalle->ProductoSecundario_id)->Cantidad;

               // $cantidadActualizarSecu = $cantidadProductoSecun + ($cantidadPrincipal / $cantidadequivalenciaSecun);
                $cantidadActualizarSecu = $cantidadProductoSecun + ($cantidadPrincipal * $cantidadequivalenciaSecun);
                $this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoSecunDetalle->ProductoSecundario_id, $cantidadActualizarSecu);
             }
        }
    }*/


}