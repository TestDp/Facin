<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 3/09/2018
 * Time: 11:59 AM
 */

namespace Facin\Datos\Modelos\MSistema;


use Illuminate\Database\Eloquent\Model;


class RecursoSistema extends  Model
{

    protected $table = 'Tbl_Recursos_Sistemas';
    protected $fillable =['Nombre','Descripcion','UrlRecurso','RecursoSistemaPadre_id'];

    public function roles()
    {
        return $this
            ->belongsToMany(Rol::class,'Tbl_Recursos_Sistemas_Por_Rol','RecursoSistema_id','Rol_id')
            ->withTimestamps();
    }

}