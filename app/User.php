<?php

namespace App;

use Facin\Datos\Modelos\MEmpresa\Sede;
use Facin\Datos\Modelos\MSistema\Rol;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','last_name','username', 'email', 'password','Sede_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function roles()
    {
        return $this
            ->belongsToMany(Rol::class,'Tbl_Roles_Por_Usuarios','user_id','Rol_id')
            ->withTimestamps();
    }
    public function Sede()
    {
        return $this->belongsTo(Sede::class,'Sede_id');
    }
}
