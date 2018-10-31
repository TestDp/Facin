<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 5/10/2018
 * Time: 10:07 AM
 */

namespace Facin\Datos\Modelos\MFacturacion;


use Illuminate\Database\Eloquent\Model;

class EstadoFactura extends Model
{
    protected $table = 'Tbl_Estados_Facturas';
    protected $fillable =['Nombre','Descripcion'];

    public function Facturas(){

        return $this->hasMany(Factura::class,'EstadoFactura_id','id');
    }

}