<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/08/2018
 * Time: 12:55 PM
 */

namespace Facin\Datos\Modelos\MSistema;


use Facin\Datos\Modelos\MInventario\ProductoPorProveedor;
use Illuminate\Database\Eloquent\Model;

class UnidadDeMedida extends  Model
{
    protected $table = 'Tbl_Unidades_De_Medidas';
    protected $fillable =['Unidad','Abreviatura','Descripcion'];

    public function Productos(){
        return $this->hasMany(ProductoPorProveedor::class,'UnidadDeMedida_id','id');
    }

}