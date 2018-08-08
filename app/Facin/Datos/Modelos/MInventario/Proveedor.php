<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 1:08 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'Tbl_Proveedores';
    protected $fillable =['Nombre','Descripcion'];
}