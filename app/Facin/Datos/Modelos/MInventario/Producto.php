<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:29 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    protected $table = 'Tbl_Productos';
    protected $fillable =['Codigo','Nombre','Precio','Cantidad','ImagenProducto'];


}