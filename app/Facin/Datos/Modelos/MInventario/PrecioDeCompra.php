<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 2:34 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Illuminate\Database\Eloquent\Model;

class PrecioDeCompra extends Model
{
    protected $table = 'Tbl_Precios_De_Compra';
    protected $fillable =['Cantidad','Precio','NumFacturaProvedor','ProductoPorProveedor_id','Comentarios'];

    public function ProductoPorProveedor()
    {
        return $this->belongsTo(ProductoPorProveedor::class,'ProductoPorProveedor_id');
    }

}