<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:29 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Facin\Datos\Modelos\MSistema\TipoDeProducto;
use Facin\Datos\Modelos\MSistema\UnidadDeMedida;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Tbl_Productos';

    //Cantidad: es la cantidad minimma para mantener en el inventario
    protected $fillable =['Codigo','Nombre','Precio','PrecioSinIva','ImagenProducto',
                          'Almacen_id','Categoria_id','UnidadDeMedida_id','TipoDeProducto_id','EsCombo','TieneEquivalencia'];

    public function Almacen()
    {
        return $this->belongsTo(Almacen::class,'Almacen_id');
    }

    public function Categoria()
    {
        return $this->belongsTo(Categoria::class,'Categoria_id');
    }

    public function UnidadDeMedida()
    {
        return $this->belongsTo(UnidadDeMedida::class,'UnidadDeMedida_id');
    }

    public function ProductsoPorProveedores(){
        return $this->hasMany(ProductoPorProveedor::class,'Producto_id','id');
    }

    public function TipoDeProducto()
    {
        return $this->belongsTo(TipoDeProducto::class,'TipoDeProducto_id');
    }

    public function GruposDeProductosPrincipales(){
        return $this->hasMany(GrupoDeProductos::class,'ProductoPrincipal_id','id');
    }

    public function GruposDeProductosSecundario(){
        return $this->hasMany(GrupoDeProductos::class,'ProductoSecundario_id','id');
    }

    public function EquivalenciasPrincipales(){
        return $this->hasMany(Equivalencia::class,'ProductoPrincipal_id','id');
    }

    public function EquivalenciasSecundarias(){
        return $this->hasMany(Equivalencia::class,'ProductoSecundario_id','id');
    }
}