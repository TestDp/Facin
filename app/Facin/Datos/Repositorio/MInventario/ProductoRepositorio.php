<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 3:01 PM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MInventario\GrupoDeProductos;
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
            if(!$request->EsCombo)
                $producto->EsCombo = 0;
            $producto->save();
            if($request->Proveedor_id)//preguntamos si viene la lista Proveedor_id
            {
                $productoXProveedor = new ProductoPorProveedor();
                $productoXProveedor->Producto_id =  $producto->id;
                $productoXProveedor->Proveedor_id = $request->Proveedor_id;
                $productoXProveedor->Cantidad = 0;
                $productoXProveedor->CantidadMinima = 0;
                $productoXProveedor->save();
            }
            $indCantidad=0;
            if($request->ProductoSecundario_id)//preguntamos si viene la lista ProductoSecundario_id
            foreach ($request->ProductoSecundario_id as $idProductoSecundario){
                $grupoProducto = new GrupoDeProductos();
                $grupoProducto->ProductoPrincipal_id =  $producto->id;
                $grupoProducto->ProductoSecundario_id = $idProductoSecundario;
                $grupoProducto->Cantidad = $request->Cantidad[$indCantidad];
                $grupoProducto->save();
                $indCantidad++;
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

    public function ObtenerProductoPorEmpresaYProveedor($idEmpreesa)
    {
        $productos = ProductoPorProveedor::all();
        $ListaProductosEmpresa = array();
        foreach ($productos as $productoProveedor) {
            if($productoProveedor->Producto->Almacen->Sede->Empresa->id ==$idEmpreesa)
                $ListaProductosEmpresa[]=$productoProveedor;
        }
        return $ListaProductosEmpresa;
    }

    public function ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa)
    {
        $productos = Producto::where('EsCombo','<>',1)->get();
        $ListaProductosEmpresa = array();
        foreach ($productos as $producto) {
            if($producto->Almacen->Sede->Empresa->id ==$idEmpreesa)
                $ListaProductosEmpresa[]=$producto;
        }
        return $ListaProductosEmpresa;
    }
}