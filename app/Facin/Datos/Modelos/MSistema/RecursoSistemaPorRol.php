<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 3/09/2018
 * Time: 12:43 PM
 */

namespace Facin\Datos\Modelos\MSistema;


use Illuminate\Database\Eloquent\Model;

class RecursoSistemaPorRol extends Model
{
    protected $table = 'Tbl_Recursos_Sistemas_Por_Rol';
    protected $fillable =['Rol_id','RecursoSistema_id'];
}