<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/08/2018
 * Time: 12:55 PM
 */

namespace Facin\Datos\Modelos\MSistema;


use Facin\Datos\Modelos\MInventario\Producto;
use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Illuminate\Database\Eloquent\Model;

class UnidadDeMedida extends  Model
{
    protected $table = 'Tbl_Unidades_De_Medidas';
    protected $fillable =['Unidad','Abreviatura','Descripcion'];

    public function Productos(){
        return $this->hasMany(Producto::class,'UnidadDeMedida_id','id');
    }

    /**public function UnidadesDeMedidaPrincipales(){
        return $this->hasMany(Equivalencia::class,'UnidadDeMedidaPrincipal_id','id');
    }

    public function UnidadesDeMedidaSecundarias(){
        return $this->hasMany(Equivalencia::class,'UnidadDeMedidaSecundaria_id','id');
    }**/

}