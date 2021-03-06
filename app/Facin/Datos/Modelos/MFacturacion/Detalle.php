<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:52 PM
 */

namespace Facin\Datos\Modelos\MFacturacion;


use Facin\Datos\Modelos\MInventario\Producto;
use Illuminate\Database\Eloquent\Model;

class Detalle extends Model
{
    protected $table = 'Tbl_Detalles_Facturas';
    protected $fillable =['SubTotal','Cantidad','Descuento','Producto_id','Factura_id','Comentario'];

    public function Producto()
    {
        return $this->belongsTo(Producto::class,'Producto_id');
    }
    public function Factura()
    {
        return $this->belongsTo(Factura::class,'Factura_id');
    }

}