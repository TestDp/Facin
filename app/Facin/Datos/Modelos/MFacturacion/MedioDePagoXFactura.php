<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 29/10/2018
 * Time: 1:09 PM
 */

namespace Facin\Datos\Modelos\MFacturacion;


use Illuminate\Database\Eloquent\Model;

class MedioDePagoXFactura extends Model
{
    protected $table = 'Tbl_Medio_De_Pago_X_Factura';
    protected $fillable =['Valor','Factura_id','MedioDePago_id'];

    public function Factura()
    {
        return $this->belongsTo(Factura::class,'Factura_id');
    }

    public function MedioDePago()
    {
        return $this->belongsTo(MedioDePago::class,'MedioDePago_id');
    }
}