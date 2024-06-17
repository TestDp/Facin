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

    public function ObtenerListaProductoPrincipalesPorEmpresa($idEmpreesa){
        return $this->productoRepositorio->ObtenerListaProductoPrincipalesPorEmpresa($idEmpreesa);
    }

    public function ObtenerProductoPorEmpresaYProveedor($idEmpreesa){
        return $this->productoRepositorio->ObtenerProductoPorEmpresaYProveedor($idEmpreesa);
    }

    public function ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa){
        return $this->productoRepositorio->ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa);
    }

    public function ObtenerListaProductoPorEmpresaCombo($idEmpreesa){
        return $this->productoRepositorio->ObtenerListaProductoPorEmpresaCombo($idEmpreesa);
    }
    public function ObtenerListaProductoPorEmpresaDelCombo($idEmpreesa){
        return $this->productoRepositorio->ObtenerListaProductoPorEmpresaDelCombo($idEmpreesa);
    }

    public function ObtenerProductoXProveedor($idProducto,$idProveedor){
        return $this->productoRepositorio->ObtenerProductoXProveedor($idProducto,$idProveedor);
    }

    public function ObtenerProductoProveedorIdproducto($idProducto){
        return $this->productoRepositorio->ObtenerProductoProveedorIdproducto($idProducto);
    }

    public function ObtenerProdConInventarioTotal($idProducto){
            if($this->productoRepositorio->EsProductoPrincipal($idProducto)){
                return $this->productoRepositorio->ObtenerProdConInventarioTotal($idProducto);
            }else{
                $equivalencia = $this->productoRepositorio->ObtenerProductoEquivalencia($idProducto);
                $cantidadEquivalencia = $equivalencia->Cantidad;
                $productoInveTotal = $this->productoRepositorio->ObtenerProdConInventarioTotal($equivalencia->ProductoPrincipal_id);
                $productoInveTotal->Cantidad = $cantidadEquivalencia * $productoInveTotal->Cantidad;
                return $productoInveTotal;
            }

    }

    public function ObtenerProdConInvenTotalTodoTipo($idProducto){
        if($this->productoRepositorio->ObtenerProducto($idProducto)->EsCombo){
            $prodsDelCombo = $this->productoRepositorio->ObtenerListaProductoDelComboPorProducto($idProducto);
            $productoInveTotal ='';
            foreach ($prodsDelCombo as $prodCombo){
                $productoInveTotal = $this->ObtenerProdConInventarioTotal($prodCombo->ProductoSecundario_id);
                if($prodCombo->Cantidad > $productoInveTotal->Cantidad){
                    $productoInveTotal->Cantidad = 0;
                    return $productoInveTotal;
                }
            }
            return $productoInveTotal;
        }
        return $this->ObtenerProdConInventarioTotal($idProducto);
    }

    public function GuardarEquivalencia($idProductoP,$idProductoS,$cantidad)
    {
        return $this->productoRepositorio->GuardarEquivalencia($idProductoP,$idProductoS,$cantidad);
    }

    public function ObtenerListaProductoDelComboPorProducto($idProducto)
    {
        return $this->productoRepositorio->ObtenerListaProductoDelComboPorProducto($idProducto);
    }
}