<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 25/08/2018
 * Time: 12:05 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Facin\Datos\Modelos\MEmpresa\Sede;
use Illuminate\Database\Eloquent\Model;

class Almacen extends  Model
{
    protected $table = 'Tbl_Almacenes';
    protected $fillable =['Nombre','Ubicacion','Sede_id'];

    public function Sede()
    {
        return $this->belongsTo(Sede::class,'Sede_id');
    }

    public function Productos(){
        return $this->hasMany(ProductoPorProveedor::class,'Almacen_id','id');
    }

}