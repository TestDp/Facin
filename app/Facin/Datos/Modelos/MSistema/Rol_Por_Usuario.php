<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 9/08/2018
 * Time: 12:52 PM
 */

namespace Facin\Datos\Modelos\MSistema;


class Rol_Por_Usuario
{
    protected $table = 'Tbl_Roles_Por_Usuarios';
    protected $fillable =['Rol_id','users_id'];
}