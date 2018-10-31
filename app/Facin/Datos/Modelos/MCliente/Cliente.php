<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:57 PM
 */

namespace Facin\Datos\Modelos\MCliente;


use Facin\Datos\Modelos\MFacturacion\Factura;
use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'Tbl_Clientes';
    protected $fillable =['Identificacion','Nombre','Apellidos','Telefono','CorreoElectronico','Empresa_id'];

    public function Facturas(){
        return $this->hasMany(Factura::class,'Cliente_id','id');
    }
}