<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 5/10/2018
 * Time: 10:07 AM
 */

namespace Facin\Datos\Modelos\MFacturacion;


class EstadoFactura extends Model
{
    protected $table = 'Tbl_Estados_Facturas';
    protected $fillable =['Nombre','Descripcion'];
}