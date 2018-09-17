<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 29/08/2018
 * Time: 2:22 PM
 */

namespace App\Facin\Datos\Repositorio\MInventario;

use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Illuminate\Support\Facades\DB;

class InventarioRepositorio
{

    //parametros:$precioDeCompra(modelo PrecioDeCompra) $productoXProveedor(modelo ProductoPorProveedor)
    public  function GuardarInventario($precioDeCompra,$productoXProveedor)
    {
        DB::beginTransaction();
        try {
            $precioDeCompra->save();
            $productoXProveedor->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }
    //Parametros:Pk tabla de producto($idProducto) Pk tabla de proveedor($idProveedor)
    public function ObtenerProductoXProveedor($idProducto,$idProveedor)
    {
        return ProductoPorProveedor::where('Producto_id','=',$idProducto)->where('Proveedor_id','=',$idProveedor)->get()->first();
    }

    //Parametros:Pk tabla de producto($idProducto)
    public function ObtenerProductoProveedorIdproducto($idProducto)
    {
        return ProductoPorProveedor::where('Producto_id','=',$idProducto)->get()->first();
    }
}