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

class InventarioServicio
{
    protected  $inventarioRepositorio;

    public function __construct(InventarioRepositorio $inventarioRepositorio){
        $this->inventarioRepositorio = $inventarioRepositorio;
    }

    public  function GuardarInventario($request){
        $precioDeCompra = new PrecioDeCompra($request->all());
        $productoXProveedor = $this->inventarioRepositorio->ObtenerProductoProveedorIdproducto($request->Producto_id);
        $productoXProveedor->Cantidad = $productoXProveedor->Cantidad + $request->Cantidad;
        $precioDeCompra->ProductoPorProveedor_id = $productoXProveedor->id;
        return $this->inventarioRepositorio->GuardarInventario($precioDeCompra,$productoXProveedor);
    }
}