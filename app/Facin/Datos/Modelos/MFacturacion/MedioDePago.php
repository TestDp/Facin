<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:53 PM
 */

namespace Facin\Datos\Modelos\MFacturacion;


use Illuminate\Database\Eloquent\Model;

class MedioDePago extends Model
{
    protected $table = 'Tbl_Medios_De_Pagos';
    protected $fillable =['Nombre','Descripcion'];
}