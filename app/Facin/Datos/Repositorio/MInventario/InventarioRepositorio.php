<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 29/08/2018
 * Time: 2:22 PM
 */

namespace App\Facin\Datos\Repositorio\MInventario;

use Facin\Datos\Modelos\MInventario\PrecioDeCompra;
use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Facin\Datos\Repositorio\MInventario\ProductoRepositorio;
use Illuminate\Support\Facades\DB;

class InventarioRepositorio
{
    protected  $productoRepositorio;

    public function __construct(ProductoRepositorio $productoRepositorio){
        $this->productoRepositorio = $productoRepositorio;

    }

    //parametros:$precioDeCompra(modelo PrecioDeCompra), $productoXProveedor(modelo ProductoPorProveedor),$producto(modelo de producto)
    public  function GuardarInventario($precioDeCompra,$productoXProveedor,$producto)
    {
        DB::beginTransaction();
        try {
            $productoXProveedor->save();
            $precioDeCompra->ProductoPorProveedor_id = $productoXProveedor->id;
            $precioDeCompra->save();
            if($producto!= null){
                $producto->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public function ActualizarInventarioProductoPrincipalXXX($productoPrincipalId,$cantidadActualizarPrincipal)
    {
        ProductoPorProveedor::where('Producto_id','=',$productoPrincipalId)->update(array('Cantidad' => $cantidadActualizarPrincipal));
    }

    public function ActualizarInventarioProducto($idProducto,$cantidad){
       $listProdsCombo =  $this->productoRepositorio->ObtenerListaProductoDelComboPorProducto($idProducto);
       if(count($listProdsCombo)>0){
           foreach ($listProdsCombo as $producto) {
              $this->ActualizarInventarioProducto($producto->ProductoSecundario_id,$producto->Cantidad * $cantidad);
           }
       }else{
           if($this->productoRepositorio->EsProductoPrincipal($idProducto)){
               $this->ActualizarInventarioProductoPrincipal($idProducto,$cantidad);
           }else{
               $equivalencia = $this->productoRepositorio->ObtenerProductoEquivalencia($idProducto);
               $this->ActualizarInventarioProducto($equivalencia->ProductoPrincipal_id,$cantidad/$equivalencia->Cantidad);
           }
       }

    }

    private function ActualizarInventarioProductoPrincipal($productoPrincipalId,$cantidadADescontar)
    {
       $productoXproveedor = ($cantidadADescontar > 0)? ProductoPorProveedor::where('Producto_id','=',$productoPrincipalId)->where('Cantidad','>',0)->first():
                                ProductoPorProveedor::where('Producto_id','=',$productoPrincipalId)->first();

       if($productoXproveedor->Cantidad >= $cantidadADescontar){
           $diferencia = $productoXproveedor->Cantidad - $cantidadADescontar;
           $productoXproveedor ->update(array('Cantidad' => $diferencia));
       }else{
           $diferencia = $cantidadADescontar-$productoXproveedor->Cantidad;
           $productoXproveedor ->update(array('Cantidad' => 0));
           if($diferencia > 0){
               $this->ActualizarInventarioProductoPrincipal($productoPrincipalId,$diferencia);
           }
       }

    }

    public function ObtenerCompras($idEmpresa){
            return DB::table('Tbl_Precios_De_Compra')
                ->join('Tbl_Productos_Por_Proveedores', 'Tbl_Precios_De_Compra.ProductoPorProveedor_id','=','Tbl_Productos_Por_Proveedores.id')
                ->join('Tbl_Proveedores', 'Tbl_Productos_Por_Proveedores.Proveedor_id','=','Tbl_Proveedores.id')
                ->join('Tbl_Empresas','Tbl_Empresas.id','=','Tbl_Proveedores.Empresa_id')
                ->select(DB::raw("DATE_FORMAT(Tbl_Precios_De_Compra.updated_at, '%Y-%m-%d') as created_at"),'Tbl_Productos_Por_Proveedores.Proveedor_id','Tbl_Proveedores.RazonSocial','Tbl_Precios_De_Compra.NumFacturaProvedor',DB::raw('sum(Tbl_Precios_De_Compra.Precio * Tbl_Precios_De_Compra.Cantidad) as Total'))
                ->groupBy('created_at','Tbl_Productos_Por_Proveedores.Proveedor_id','Tbl_Proveedores.RazonSocial','Tbl_Precios_De_Compra.NumFacturaProvedor')
                ->where('Tbl_Empresas.id', '=', $idEmpresa)
                ->latest()
                ->paginate(10);
    }

    public function ConsultarCompra($idEmpresa,$fecha,$numFactura){
        $compras =  DB::table('Tbl_Precios_De_Compra')
            ->join('Tbl_Productos_Por_Proveedores', 'Tbl_Precios_De_Compra.ProductoPorProveedor_id','=','Tbl_Productos_Por_Proveedores.id')
            ->join('Tbl_Proveedores', 'Tbl_Productos_Por_Proveedores.Proveedor_id','=','Tbl_Proveedores.id')
            ->join('Tbl_Empresas','Tbl_Empresas.id','=','Tbl_Proveedores.Empresa_id')
            ->join('Tbl_Productos', 'Tbl_Productos.id','=','Tbl_Productos_Por_Proveedores.Producto_id')
            ->select('Tbl_Productos.Nombre','Tbl_Precios_De_Compra.Cantidad','Tbl_Precios_De_Compra.Precio')
            //->groupBy('created_at','Tbl_Productos_Por_Proveedores.Proveedor_id','Tbl_Proveedores.RazonSocial','Tbl_Precios_De_Compra.NumFacturaProvedor')
            ->where('Tbl_Empresas.id', '=', $idEmpresa)
            ->where('Tbl_Precios_De_Compra.NumFacturaProvedor','=',$numFactura)
            ->where(DB::raw("DATE_FORMAT(Tbl_Precios_De_Compra.updated_at, '%Y-%m-%d')"),'=',$fecha)
            ->get();
        return $compras;
    }

}