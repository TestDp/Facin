<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 3:01 PM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MEmpresa\Empresa;
use Facin\Datos\Modelos\MInventario\Equivalencia;
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

    public  function EditarProducto($request)
    {
        DB::beginTransaction();
        try {

            $producto = Producto::find($request['id']);
            $producto->Codigo = $request['Codigo'];
            $producto->Nombre = $request['Nombre'];
            $producto->Precio = $request['Precio'];
            $producto->TipoDeProducto_id = $request['TipoDeProducto_id'];
            $producto->Categoria_id = $request['Categoria_id'];
            $producto->UnidadDeMedida_id = $request['UnidadDeMedida_id'];
            $producto->Almacen_id = $request['Almacen_id'];
            $producto->PrecioSinIva = $request['PrecioSinIva'];
           // $producto->PrecioConIva = $request['PrecioConIva'];

            if(!$request['EsCombo'])
                $producto->EsCombo = 0;
            $producto->save();
            if($producto->EsCombo == 0)//preguntamos si viene la lista Proveedor_id
            {
                //$productoXProveedor = ProductoPorProveedor::find($request['id']);
                $productoXProveedor = ProductoPorProveedor::where('Producto_id','=',$request['id'])->get()->first();
                $productoXProveedor->Proveedor_id = $request['Proveedor_id'];
                $productoXProveedor->Producto_id =  $producto->id;
                $productoXProveedor->save();
            }
            $indCantidad=0;
            if($request['ProductoSecundario_id'])//preguntamos si viene la lista ProductoSecundario_id
            {
                GrupoDeProductos::where('ProductoPrincipal_id', '=', $producto->id)->delete();
                foreach ($request->ProductoSecundario_id as $idProductoSecundario) {
                    $grupoProducto = new GrupoDeProductos();
                    $grupoProducto->ProductoPrincipal_id = $producto->id;
                    $grupoProducto->ProductoSecundario_id = $idProductoSecundario;
                    $grupoProducto->Cantidad = $request->Cantidad[$indCantidad];
                    $grupoProducto->save();
                    $indCantidad++;
                }
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }


    //me retorna un lista de producto filtrado por el id de la empresa
    public function ObtenerListaProductoPrincipalesPorEmpresa($idEmpreesa)
    {
        $productos = Producto::where('EsCombo','<>',1)->get();
        $ListaProductosEmpresa = array();
        foreach ($productos as $producto) {

            if($producto->Almacen->Sede->Empresa->id ==$idEmpreesa && $this->EsProductoPrincipal($producto->id))
                $ListaProductosEmpresa[]=$producto;
        }
        return $ListaProductosEmpresa;
    }

    //me retorna un lista de producto filtrado por el id de la empresa
    public function ObtenerListaProductoPorEmpresa($idEmpreesa)
    {
        $productos = Producto::all();
        $ListaProductosEmpresa = array();
        foreach ($productos as $producto) {
            if($producto->Almacen->Sede->Empresa->id ==$idEmpreesa)
            {   $producto->UnidadDeMedida;
                $ListaProductosEmpresa[]=$producto;
            }
        }
        return $ListaProductosEmpresa;
    }

    //retorna una lista de prodcutoPorProveedor filtrado por el id de la empresa
    public function ObtenerProductoPorEmpresaYProveedor($idEmpreesa)
    {
        $productos = ProductoPorProveedor::all();
        $ListaProductosEmpresa = array();
        foreach ($productos as $productoProveedor) {
            if($productoProveedor->Producto->Almacen->Sede->Empresa->id ==$idEmpreesa) {
                if ($this->EsProductoPrincipal($productoProveedor->Producto_id)) {
                    $ListaProductosEmpresa[] = $productoProveedor;
                } else {
                    $equivalencia = $this->ObtenerProductoEquivalencia($productoProveedor->Producto_id);
                    $cantidadEquivalencia = $equivalencia->Cantidad;
                    $cantidadProdPrincipal = $this->ObtenerProductoProveedorIdproducto($equivalencia->ProductoPrincipal_id)->Cantidad;
                    $productoProveedor->Cantidad = $cantidadEquivalencia * $cantidadProdPrincipal;
                    $ListaProductosEmpresa[] = $productoProveedor;
                }
            }
        }
        return $ListaProductosEmpresa;
    }

    //me retorna un lista de producto que no es combo filtrado por el id de la empresa
    public function ObtenerListaProductoPorEmpresaNoCombo($idEmpreesa)
    {
        $productos = Producto::where('EsCombo','<>',1)->get();
        $ListaProductosEmpresa = array();
        foreach ($productos as $producto) {
            if($producto->Almacen->Sede->Empresa->id ==$idEmpreesa) {
                $producto->UnidadDeMedida;
                $ListaProductosEmpresa[] = $producto;
            }
        }
        return $ListaProductosEmpresa;
    }

    //me retorna un lista de producto que son combo filtrado por el id de la empresa
    public function ObtenerListaProductoPorEmpresaCombo($idEmpreesa)
    {
        $productos = GrupoDeProductos::all();
        $ListaProductosEmpresa = array();
        foreach ($productos as $productoGrupo) {
            if($productoGrupo->ProductoPrincipal->Almacen->Sede->Empresa->id ==$idEmpreesa ){
                $ListaProductosEmpresa[]=$productoGrupo->ProductoPrincipal;
            }
        }
        $ListaProductosEmpresa = array_unique($ListaProductosEmpresa);
        return $ListaProductosEmpresa;
    }

    //me retorna un lista de producto que hacen parte del combo filtrado por el id de la empresa
    public function ObtenerListaProductoPorEmpresaDelCombo($idEmpreesa)
    {
        $productos = GrupoDeProductos::all();
        $ListaProductosEmpresa = array();
        foreach ($productos as $productoProveedor) {
            if($productoProveedor->ProductoPrincipal->Almacen->Sede->Empresa->id ==$idEmpreesa ){
                $ListaProductosEmpresa[]=$productoProveedor;
                $productoProveedor->ProductoSecundario;
            }
        }
        return $ListaProductosEmpresa;
    }

    //me retorna un lista de producto que hacen parte del combo filtrado por el id del producto principal
    public function ObtenerListaProductoDelComboPorProducto($idProducto)
    {
        return GrupoDeProductos::where('ProductoPrincipal_id','=',$idProducto)->get();
    }

    //Parametros:Pk tabla de producto($idProducto) Pk tabla de proveedor($idProveedor)
    //retorna: un productoPorProveedor filtrado por el id o pk del producto y id o pk del producto
    public function ObtenerProductoXProveedor($idProducto,$idProveedor)
    {
        return ProductoPorProveedor::where('Producto_id','=',$idProducto)->where('Proveedor_id','=',$idProveedor)->get()->first();
    }

    //Parametros:Pk tabla de producto($idProducto)
    //retorna: un productoPorProveedor filtrado por el id o pk del producto
    public function ObtenerProductoProveedorIdproducto($idProducto)
    {
        $productoProvvedor = ProductoPorProveedor::where('Producto_id','=',$idProducto)->get()->first();
        $productoProvvedor->Producto;
        return $productoProvvedor;
    }

    public function ObtenerProdConInventarioTotal($idProducto){
        $productoProvvedor = ProductoPorProveedor::where('Producto_id','=',$idProducto)->get();
        $suma =  $productoProvvedor->sum('Cantidad');
        $productoProvvedor = $productoProvvedor->first();
        $productoProvvedor->Cantidad = $suma;
        $productoProvvedor->Producto;
        return $productoProvvedor;
    }

    //Parametros:Pk tabla de producto($idProducto)
    //retorna:un producto filtrado por el id o pk del producto
    public function ObtenerProducto($idProducto){
        $Producto = Producto::find($idProducto);
        $Producto->UnidadDeMedida;
        return $Producto;
    }

    //Metodo que me guarda la equivalencia de un producto
    public function GuardarEquivalencia($idProductoP,$idProductoS,$cantidad)
    {
        DB::beginTransaction();
        try {
            $equivalencia =  new Equivalencia();
            $equivalencia->ProductoPrincipal_id = $idProductoP;
            $equivalencia->ProductoSecundario_id = $idProductoS;
            $equivalencia->Cantidad = $cantidad;
            $equivalencia->save();
            DB::commit();
            return array('respuesta' =>true,'ProductoPpal'=>$this->ObtenerProducto($idProductoP),'ProductoSec'=>$this->ObtenerProducto($idProductoS));

        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    //Parametros:Pk tabla de producto($idProducto)
    //retorna:un producto filtrado por el id o pk del producto de la tabla equivalencias
    public function ObtenerProductoEquivalencia($idProducto){
        $Producto = Equivalencia::where('ProductoSecundario_id','=',$idProducto)->get()->first();
        $Producto->ProductoPrincipal;
        return $Producto;
    }

    //Parametros:Pk tabla de producto($idProducto)
    //retorna:un producto filtrado por el id o pk del producto de la tabla equivalencias
    public function EsProductoPrincipal($idProducto){
        $Producto = Equivalencia::where('ProductoSecundario_id','=',$idProducto)->get()->count();
        if($Producto == 0)
        {
            return true;
        }
        return false;
    }
    //me retorna un lista de producto que no es combo filtrado por el id de la empresa
    public function ObtenerProductosSecundarios($idProducto)
    {
        $ListaproductosSecundarios = Equivalencia::where('ProductoPrincipal_id','=',$idProducto)->get();
        return $ListaproductosSecundarios;
    }



}