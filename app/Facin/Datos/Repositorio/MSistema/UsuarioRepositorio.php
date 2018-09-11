<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 6/09/2018
 * Time: 3:34 PM
 */

namespace Facin\Datos\Repositorio\MSistema;


use App\User;
use Illuminate\Support\Facades\DB;

class UsuarioRepositorio
{

    public  function  ObtenerListaUsuarios($idEmpresa,$idUsuario)
    {
        $users = DB::table('users')
            ->join('Tbl_Sedes', 'Tbl_Sedes.id', '=', 'users.Sede_id')
            ->join('Tbl_Empresas', 'Tbl_Empresas.id', '=', 'Tbl_Sedes.Empresa_id')
            ->select('users.*')
            ->where('Tbl_Empresas.id', '=', $idEmpresa)
            ->where('users.id','<>',$idUsuario)
            ->get();
        return $users;
    }
}