<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 9/08/2018
 * Time: 10:23 AM
 */

namespace Facin\Datos\Modelos\MInventario;


use Illuminate\Database\Eloquent\Model;

class ProductoPorProveedor extends Model
{
    protected $table = 'Tbl_Productos_Por_Proveedores';
    protected $fillable =['Cantidad','Producto_id','Proveedor_id'];
}