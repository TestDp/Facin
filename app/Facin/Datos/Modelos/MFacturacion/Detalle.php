<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:52 PM
 */

namespace Facin\Datos\Modelos\MFacturacion;


use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = 'Tbl_Detalle';
    protected $fillable =['SubTotal','Cantidad','Descuento','Producto_id','Factura_id'];
}