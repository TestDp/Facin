<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:57 PM
 */

namespace Facin\Datos\Modelos\MCliente;


use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'Tbl_Clientes';
    protected $fillable =['Identificacion','Nombre','Apellidos','Telefono','CorreoElectronico'];
}