<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 3:01 PM
 */

namespace Facin\Negocio\Logica\MInventario;


use Facin\Datos\Repositorio\MInventario\ProductoRepositorio;

class ProductoServicio
{
    protected  $productoRepositorio;

    public function __construct(ProductoRepositorio $productoRepositorio){
        $this->productoRepositorio = $productoRepositorio;
    }

    public  function GuardarProducto($request){

        if(isset($request['id']))
        {
            return $this->productoRepositorio->EditarProducto($request);

        }else{
            return $this->productoRepositorio->GuardarProducto($request);
        }

    }

    public  function  ObtenerProducto($idProducto)
    {
        return $this->productoRepositorio->ObtenerProducto($idProducto);
    }

    public function ObtenerListaProductoPorEmpresa($idEmpreesa){
        return $this->productoRepositorio->ObtenerListaProductoPorEmpresa($idEmpreesa);
    }

    public function ObtenerProductoPorEmpresaYProveedor($idEmpreesa){
        return $this->productoRepositorio->ObtenerProductoPorEmpresaYProveedor($idEmpreesa);
    }

    public function ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa){
        return $this->productoRepositorio->ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa);
    }

    public function ObtenerProductoXProveedor($idProducto,$idProveedor){
        return $this->productoRepositorio->ObtenerProductoXProveedor($idProducto,$idProveedor);
    }

    public function ObtenerProductoProveedorIdproducto($idProducto){
        return $this->productoRepositorio->ObtenerProductoProveedorIdproducto($idProducto);
    }

    public function GuardarEquivalencia($idProductoP,$idProductoS,$cantidad)
    {
        return $this->productoRepositorio->GuardarEquivalencia($idProductoP,$idProductoS,$cantidad);
    }
}