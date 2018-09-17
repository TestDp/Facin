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

    //parametros:$precioDeCompra(modelo PrecioDeCompra), $productoXProveedor(modelo ProductoPorProveedor),$producto(modelo de producto)
    public  function GuardarInventario($precioDeCompra,$productoXProveedor,$producto)
    {
        DB::beginTransaction();
        try {
            $precioDeCompra->save();
            $productoXProveedor->save();
            $producto->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }


}