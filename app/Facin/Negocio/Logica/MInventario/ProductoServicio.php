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

    public function  ObtenerTodosLosProductosConStock($idEmpresa){
        $productosSinStock = $this->productoRepositorio->ObtenerTodosLosProductosSinStock($idEmpresa);
        foreach ($productosSinStock as $producto){
            $producto->Cantidad =  $this->ObtenerProdConInvenTotalTodoTipo($producto->id)->Cantidad;
        }
        return $productosSinStock;
    }

    public function ObtenerProductoPorEmpresaYProveedor($idEmpreesa){
        return $this->productoRepositorio->ObtenerProductoPorEmpresaYProveedor($idEmpreesa);
    }

    public function ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa){
        return $this->productoRepositorio->ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa);
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
            $productoInveTotal = $this->ObtenerProdConInventarioTotal($equivalencia->ProductoPrincipal_id);
            $productoInveTotal->Cantidad = $cantidadEquivalencia * $productoInveTotal->Cantidad;
            return $productoInveTotal;
        }
    }

    //este metodo me retorna el inventario del producto desde el arbol de equivalencias.
    public function ObtenerProdConInvenTotalTodoTipo($idProducto){
        if($this->productoRepositorio->ObtenerProducto($idProducto)->EsCombo){
            $prodsDelCombo = $this->productoRepositorio->ObtenerListaProductoDelComboPorProducto($idProducto);
            $ProdComboInMin = '';
            $iniciarProdCombMin = true;
            foreach ($prodsDelCombo as $prodCombo){
                $productoInveTotal = $this->ObtenerProdConInventarioTotal($prodCombo->ProductoSecundario_id);
                if($iniciarProdCombMin){
                    $ProdComboInMin = $productoInveTotal;
                    $iniciarProdCombMin = false;
                }
                if($prodCombo->Cantidad > $productoInveTotal->Cantidad){
                    $ProdComboInMin->Cantidad = 0;
                    return $ProdComboInMin;
                }
                if($ProdComboInMin->Cantidad  > $productoInveTotal->Cantidad){
                    $ProdComboInMin = $productoInveTotal;
                }
            }
            return $ProdComboInMin;
        }
        return $this->ObtenerProdConInventarioTotal($idProducto);
    }

    public function ObtenerListaProductoDelComboPorProducto($idProducto)
    {
        return $this->productoRepositorio->ObtenerListaProductoDelComboPorProducto($idProducto);
    }

    public function DesactivarProducto($idProducto){
        return $this->productoRepositorio->DesactivarProducto($idProducto);
    }

    public function ActivarProducto($idProducto){
        return $this->productoRepositorio->ActivarProducto($idProducto);
    }

    //metodo que retorna la lista de productos no combo sin relaciones o equivalencias.
    public function ObtenerListProdSinRelOEqui($idEmpresa,$idProducto){
        $productosSinStock = $this->productoRepositorio->ObtenerTodosLosProductosSinStock($idEmpresa);
        $productosSinEqui =   $this->QuitarProductosRelacionadosHaciaArriba($idProducto,$productosSinStock);
        $productosSinEqui =   $this->QuitarProductosRelacionadosHaciaAbajo($idProducto,$productosSinEqui->whereNotIn('id',$idProducto));
        return $productosSinEqui->whereNotIn('id',$idProducto);
    }

    //metodo que filtra los productos relacionados en el arbol de relaciones hacia arriba es decir desde los subproductos
    //en direccion al producto principal o raiz del arbol.
    private function QuitarProductosRelacionadosHaciaArriba($idProducto,$listproductos){
        if($this->productoRepositorio->EsProductoPrincipal($idProducto)){
            return $listproductos->whereNotIn('id',$idProducto);

        }else{
            $equivalencia = $this->productoRepositorio->ObtenerProductoEquivalencia($idProducto);
            $listproductos = $this->QuitarProductosRelacionadosHaciaArriba($equivalencia->ProductoPrincipal_id,$listproductos);
            return $listproductos->whereNotIn('id',$equivalencia->ProductoPrincipal_id);
        }
    }

    //metodo que filtra los productos relacionados en el arbol de relaciones desde el producto principal hacia los subproductos
    //es decir en direcion a las hojas del arbol
    private function QuitarProductosRelacionadosHaciaAbajo($idProducto,$listproductos){
        $equivalencia = $this->productoRepositorio->ObtenerProductoEquivalenciaXIdProdPPal($idProducto);
        if($equivalencia != null){
            $listproductos = $this->QuitarProductosRelacionadosHaciaAbajo($equivalencia->ProductoSecundario_id,$listproductos);
            return $listproductos->whereNotIn('id',$equivalencia->ProductoSecundario_id);
        }else{
            return $listproductos->whereNotIn('id',$idProducto);
        }
    }
}