<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 13/09/2018
 * Time: 2:28 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Illuminate\Database\Eloquent\Model;

class GrupoDeProductos extends Model
{

    protected $table = 'Tbl_Grupo_De_Productos';
    protected $fillable =['ProductoPrincipal_id','ProductoSecundario_id','Cantidad'];

    public function ProductoPrincipal()
    {
        return $this->belongsTo(Producto::class,'ProductoPrincipal_id');
    }

    public function ProductoSecundario()
    {
        return $this->belongsTo(Producto::class,'ProductoSecundario_id');
    }
}