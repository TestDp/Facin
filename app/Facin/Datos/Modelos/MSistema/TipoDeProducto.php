<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 12/09/2018
 * Time: 12:47 PM
 */

namespace Facin\Datos\Modelos\MSistema;


use Illuminate\Database\Eloquent\Model;

class TipoDeProducto extends Model
{
    protected $table = 'Tbl_Tipos_Productos';
    protected $fillable =['Nombre','Descripcion'];

    public function Productos(){
        return $this->hasMany(Producto::class,'TipoDeProducto_id','id');
    }
}