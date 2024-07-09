<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 3:01 PM
 */

namespace Facin\Datos\Repositorio\MInventario;



use Facin\Datos\Modelos\MInventario\Equivalencia;
use Facin\Datos\Modelos\MInventario\GrupoDeProductos;
use Facin\Datos\Modelos\MInventario\Producto;
use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Illuminate\Support\Facades\DB;
use mysql_xdevapi\Collection;

class ProductoRepositorio
{

    public  function GuardarProducto($request)
    {
        DB::beginTransaction();
        try {
            $producto = new Producto($request->all());
            if(!$request->EsCombo)
            {
             $producto->EsCombo = 0;
            }
            $producto->EsActivo = true;
            $producto->save();
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

            if($request['EsCombo'] ==0)
              {
                  $producto->EsCombo = 0;
              }else{
                $producto->EsCombo = 1;
            }
            $producto->save();
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
    public function ObtenerListaProductoPorEmpresa($idEmpresa)
    {
        return DB::table('Tbl_Sedes')
            ->join('Tbl_Almacenes','Tbl_Almacenes.Sede_id','=','Tbl_Sedes.id')
            ->join('Tbl_Productos','Tbl_Productos.Almacen_id','=','Tbl_Almacenes.id')
            ->join('Tbl_Unidades_De_Medidas','Tbl_Productos.UnidadDeMedida_id','=','Tbl_Unidades_De_Medidas.id')
            ->select('Tbl_Productos.*','Tbl_Unidades_De_Medidas.Unidad',)
            ->where('Tbl_Sedes.Empresa_id', '=', $idEmpresa)
            ->orderBy('Tbl_Productos.Codigo')
            ->get();
    }

    //Me retorna la cantidad el stock haciendo la multiplicacion hacia arriba del arbol de productos
    public function ObtenerTodosLosProductosSinStock($idEmpresa){
       return  DB::table('Tbl_Sedes')
            ->join('Tbl_Almacenes','Tbl_Almacenes.Sede_id','=','Tbl_Sedes.id')
            ->join('Tbl_Productos','Tbl_Productos.Almacen_id','=','Tbl_Almacenes.id')
            ->join('Tbl_Unidades_De_Medidas','Tbl_Productos.UnidadDeMedida_id','=','Tbl_Unidades_De_Medidas.id')
            ->select('Tbl_Productos.id','Tbl_Productos.Codigo','Tbl_Productos.Nombre','Tbl_Productos.Precio','Tbl_Unidades_De_Medidas.Unidad','Tbl_Productos.EsCombo',DB::raw('"0" as Cantidad'))
            ->groupBy('Tbl_Productos.id','Tbl_Productos.Codigo','Tbl_Productos.Nombre','Tbl_Productos.Precio','Tbl_Unidades_De_Medidas.Unidad','Tbl_Productos.EsCombo','Cantidad')
            ->where('Tbl_Sedes.Empresa_id', '=', $idEmpresa)
            //->where('Tbl_Productos.EsCombo', '<>', 1)
            ->orderBy('Tbl_Productos.Codigo')
           ->paginate(10);
            //->get();
    }

    //retorna una lista de prodcutoPorProveedor filtrado por el id de la empresa
    public function ObtenerProductoPorEmpresaYProveedor($idEmpresa)
    {
        $productos =   DB::table('Tbl_Productos_Por_Proveedores')
            ->join('Tbl_Proveedores', 'Tbl_Productos_Por_Proveedores.Proveedor_id','=','Tbl_Proveedores.id')
            ->join('Tbl_Empresas','Tbl_Empresas.id','=','Tbl_Proveedores.Empresa_id')
            ->join('Tbl_Productos','Tbl_Productos_Por_Proveedores.Producto_id','=','Tbl_Productos.id')
            ->join('Tbl_Unidades_De_Medidas','Tbl_Productos.UnidadDeMedida_id','=','Tbl_Unidades_De_Medidas.id')
            ->select('Tbl_Productos.id','Tbl_Productos.Codigo','Tbl_Productos.Nombre','Tbl_Productos.Precio','Tbl_Unidades_De_Medidas.Unidad',DB::raw('sum(Tbl_Productos_Por_Proveedores.Cantidad) as Cantidad'))
            ->groupBy('Tbl_Productos.id','Tbl_Productos.Codigo','Tbl_Productos.Nombre','Tbl_Productos.Precio','Tbl_Unidades_De_Medidas.Unidad')
            ->where('Tbl_Empresas.id', '=', $idEmpresa)
            ->orderBy('Tbl_Productos.Codigo')
            ->get();


        $ListaProductosEmpresa = array();
        foreach ($productos as $productoProveedor) {
                if ($this->EsProductoPrincipal($productoProveedor->id)) {
                    $ListaProductosEmpresa[] = $productoProveedor;
                } else {
                    $equivalencia = $this->ObtenerProductoEquivalencia($productoProveedor->id);
                    $cantidadEquivalencia = $equivalencia->Cantidad;
                    $cantidadProdPrincipal=$this->ObtenerProdConInventarioTotal($equivalencia->ProductoPrincipal_id)->Cantidad;
                    $productoProveedor->Cantidad = $cantidadEquivalencia * $cantidadProdPrincipal;
                    $ListaProductosEmpresa[] = $productoProveedor;
                }
        }
        return $ListaProductosEmpresa;
    }

    //me retorna un lista de producto que no es combo filtrado por el id de la empresa
    public function ObtenerListaProductoPorEmpresaNoCombo($idEmpresa)
    {
/*        $productos =   DB::table('Tbl_Sedes')
            ->join('Tbl_Almacenes','Tbl_Almacenes.Sede_id','=','Tbl_Sedes.id')
            ->join('Tbl_Productos','Tbl_Productos.Almacen_id','=','Tbl_Almacenes.id')
            ->join('Tbl_Unidades_De_Medidas','Tbl_Productos.UnidadDeMedida_id','=','Tbl_Unidades_De_Medidas.id')
            ->select('Tbl_Productos.id','Tbl_Productos.Codigo','Tbl_Productos.Nombre','Tbl_Productos.Precio','Tbl_Unidades_De_Medidas.Unidad')
            ->groupBy('Tbl_Productos.id','Tbl_Productos.Codigo','Tbl_Productos.Nombre','Tbl_Productos.Precio','Tbl_Unidades_De_Medidas.Unidad')
            ->where('Tbl_Sedes.Empresa_id', '=', $idEmpresa)
            ->where('Tbl_Productos.EsCombo', '<>', 1)
            ->orderBy('Tbl_Productos.Codigo')
            ->get();
        //return $productos;*/
        $productos = Producto::where('EsCombo','<>',1)->get();
        $ListaProductosEmpresa = array();
        foreach ($productos as $producto) {
            if($producto->Almacen->Sede->Empresa->id ==$idEmpresa) {
                $producto->UnidadDeMedida;
                $ListaProductosEmpresa[] = $producto;
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
        $productoProvvedor = $productoProvvedor->first() !== null ? $productoProvvedor->first(): new ProductoPorProveedor();
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

    //Parametros:Pk tabla de producto($idProducto)
    //retorna:un producto filtrado por el id o pk del producto de la tabla equivalencias
    public function ObtenerProductoEquivalencia($idProducto){
        $Producto = Equivalencia::where('ProductoSecundario_id','=',$idProducto)->get()->first();
        $Producto->ProductoPrincipal;
        return $Producto;
    }

    //Parametros:Pk tabla de producto($idProducto)
    //retorna:un producto filtrado por el id o pk del producto de la tabla equivalencias
    public function ObtenerProductoEquivalenciaXIdProdPPal($idProducto){
        $Producto = Equivalencia::where('ProductoPrincipal_id','=',$idProducto)->get()->first();
       // $Producto->ProductoPrincipal;
        return $Producto;
    }

    //Parametros:Pk tabla de producto($idProducto)
    //retorna:verdadero si no tiene equivalencias
    public function EsProductoPrincipal($idProducto){
        $Producto = Equivalencia::where('ProductoSecundario_id','=',$idProducto)->get()->count();
        if($Producto == 0)
        {
            return true;
        }
        return false;
    }

    public function DesactivarProducto($idProducto){
       $producto = Producto::find($idProducto);
       $producto->EsActivo = false;
       $producto->save();
       return $producto;
    }

    public function ActivarProducto($idProducto){
        $producto = Producto::find($idProducto);
        $producto->EsActivo = true;
        $producto->save();
        return $producto;
    }

}