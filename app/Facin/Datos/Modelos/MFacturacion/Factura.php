<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:50 PM
 */

namespace Facin\Datos\Modelos\MFacturacion;


use App\User;
use Facin\Datos\Modelos\MCliente\Cliente;
use Illuminate\Database\Eloquent\Model;

class Factura extends  Model
{
    protected $table = 'Tbl_Facturas';
    protected $fillable =['user_id','Fecha','EstadoFactura_id','Comentario','Cliente_id','TipoDeFactura_id','CantidadTotal','VentaTotal','DescuentoTotal'];

    public function MediosDePagoXFactura(){
        return $this->hasMany(MedioDePagoXFactura::class,'Factura_id','id');
    }

    public function Detalles(){
        return $this->hasMany(Detalle::class,'Factura_id','id');
    }

    public function Cliente()
    {
        return $this->belongsTo(Cliente::class,'Cliente_id');
    }

    public function Vendedor()
    {
        return $this->belongsTo(User::class,'user_id');
    }

    public function EstadoFactura()
    {
        return $this->belongsTo(EstadoFactura::class,'EstadoFactura_id');
    }

}