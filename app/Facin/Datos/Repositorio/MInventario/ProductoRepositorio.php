<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 3:01 PM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MInventario\PrecioDeCompra;
use Facin\Datos\Modelos\MInventario\Producto;
use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Illuminate\Support\Facades\DB;

class ProductoRepositorio
{

    public  function GuardarProducto($request)
    {
        DB::beginTransaction();
        try {
            $producto = new Producto($request->all());
            $producto->save();
            foreach ($request->Proveedor_id as $idProveedor){
                $productoXProveedor = new ProductoPorProveedor();
                $productoXProveedor->Producto_id =  $producto->id;
                $productoXProveedor->Proveedor_id = $idProveedor;
                $productoXProveedor->Cantidad = 0;
                $productoXProveedor->CantidadMinima = 0;
                $productoXProveedor->save();
            }

            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public function ObtenerListaProductoPorEmpresa($idEmpreesa)
    {
        $productos = Producto::all();
        $ListaProductosEmpresa = array();
        foreach ($productos as $producto) {
            if($producto->Almacen->Sede->Empresa->id ==$idEmpreesa)
                $ListaProductosEmpresa[]=$producto;
        }
        return $ListaProductosEmpresa;
    }

}