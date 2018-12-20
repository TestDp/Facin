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

        //Nuevo metodo para actualizar inventario cuando hay equivalencias
        $esPrincipal = $this->productoRepositorio->EsProductoPrincipal($request->Producto_id);
        if($esPrincipal)
        {
            $this->ActualizarProductosSecundarios($request->Producto_id, $request->Cantidad, $request->Producto_id);

        }
        else
        {
            $productoPrincipalId = $this->productoRepositorio->ObtenerProductoEquivalencia($request->Producto_id)->ProductoPrincipal_id;
            $cantidadEquivalencia = $this->productoRepositorio->ObtenerProductoEquivalencia($request->Producto_id)->Cantidad;
            $cantidadPrincipal =$this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoPrincipalId)->Cantidad;
            $cantidadActualizarEquivalente = ($request->Cantidad * $cantidadEquivalencia);
            $cantidadActualizarPrincipal = ($cantidadPrincipal + $cantidadActualizarEquivalente);
            $this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoPrincipalId,$cantidadActualizarPrincipal);
            $this->ActualizarProductosSecundarios($productoPrincipalId, $cantidadActualizarEquivalente, $request->Producto_id);

        }


        return $this->inventarioRepositorio->GuardarInventario($precioDeCompra,$productoXProveedor,$producto);
    }

    public function ActualizarProductosSecundarios($productoPrincipal, $cantidadPrincipal, $productoSecundario){

        $arrayProductosSecundarios = $this->productoRepositorio->ObtenerProductosSecundarios($productoPrincipal);

        foreach ($arrayProductosSecundarios as $productoSecunDetalle) {

            if ($productoSecundario <> $productoSecunDetalle->ProductoSecundario_id) {
            $cantidadProductoSecun = $this->productoRepositorio->ObtenerProductoProveedorIdproducto($productoSecunDetalle->ProductoSecundario_id)->Cantidad;
            $cantidadequivalenciaSecun = $this->productoRepositorio->ObtenerProductoEquivalencia($productoSecunDetalle->ProductoSecundario_id)->Cantidad;

            $cantidadActualizarSecu = $cantidadProductoSecun + ($cantidadPrincipal / $cantidadequivalenciaSecun);
            $this->inventarioRepositorio->ActualizarInventarioProductoPrincipal($productoSecunDetalle->ProductoSecundario_id, $cantidadActualizarSecu);
             }
        }
    }
}