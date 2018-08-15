<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 9/08/2018
 * Time: 10:31 AM
 */

namespace Facin\Datos\Modelos\MFacturacion;


use Illuminate\Database\Eloquent\Model;

class TipoDeFactura extends  Model
{
    protected $table = 'Tbl_Tipos_De_Facturas';
    protected $fillable =['Nombre','Descripcion'];
}