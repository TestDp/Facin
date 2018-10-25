<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 13/09/2018
 * Time: 2:28 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Facin\Datos\Modelos\MEmpresa\UnidadDeMedida;
use Illuminate\Database\Eloquent\Model;

class Equivalencia extends Model
{

    protected $table = 'Tbl_Equivalencias';
    protected $fillable =['ProductoPrincipal_id','ProductoSecundario_id','Cantidad'];

    public function ProductoPrincipal()
    {
        return $this->belongsTo(Producto::class,'ProductoPrincipal_id');
    }

    public function ProductoSecundario()
    {
        return $this->belongsTo(Producto::class,'ProductoSecundario_id');
    }

    /**public function UnidadMedidadPrincipal()
    {
        return $this->belongsTo(UnidadDeMedida::class,'UnidadDeMedidaPrincipal_id');
    }

    public function UnidadMedidadSecundario()
    {
        return $this->belongsTo(UnidadDeMedida::class,'UnidadDeMedidaSecundaria_id');
    }**/
}