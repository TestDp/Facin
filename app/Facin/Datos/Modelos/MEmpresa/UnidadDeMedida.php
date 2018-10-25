<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/08/2018
 * Time: 12:55 PM
 */

namespace Facin\Datos\Modelos\MEmpresa;


use Facin\Datos\Modelos\MInventario\Producto;
use Illuminate\Database\Eloquent\Model;

class UnidadDeMedida extends  Model
{
    protected $table = 'Tbl_Unidades_De_Medidas';
    protected $fillable =['Unidad','Abreviatura','Descripcion','Empresa_id'];

    public function Productos(){
        return $this->hasMany(Producto::class,'UnidadDeMedida_id','id');
    }

}