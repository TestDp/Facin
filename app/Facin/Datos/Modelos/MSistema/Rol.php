<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 9/08/2018
 * Time: 12:52 PM
 */

namespace Facin\Datos\Modelos\MSistema;


use App\User;
use Illuminate\Database\Eloquent\Model;

class Rol extends  Model
{
    protected $table = 'Tbl_Roles';
    protected $fillable =['Nombre','Descripcion','Empresa_id'];

    public function users()
    {
        return $this
            ->belongsToMany(User::class,'Tbl_Roles_Por_Usuarios','Rol_id','user_id')
            ->withTimestamps();
    }

    public function recursos()
    {
        return $this
            ->belongsToMany(RecursoSistema::class,'Tbl_Recursos_Sistemas_Por_Rol','Rol_id','RecursoSistema_id')
            ->withTimestamps();
    }

}