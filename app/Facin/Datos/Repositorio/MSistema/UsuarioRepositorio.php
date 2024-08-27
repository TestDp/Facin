<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 6/09/2018
 * Time: 3:34 PM
 */

namespace Facin\Datos\Repositorio\MSistema;


use App\User;
use Facin\Datos\Modelos\MSistema\Rol_Por_Usuario;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

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

    public  function  ObtenerUsuario($idUsuario)
    {
        return User::where('id', '=', $idUsuario)->get()->first();
    }

    public function GuardarUsuario($arrayUser){
        DB::beginTransaction();
        try {
            $user = new User($arrayUser);
            $user->password = Hash::make($user->password);
            $user->CorreoConfirmado = 1;
            $user->save();
            foreach ($arrayUser['Roles_id'] as $rolid){
                $rolPorUsuario = new Rol_Por_Usuario();
                $rolPorUsuario->Rol_id = $rolid;
                $rolPorUsuario->user_id = $user->id;
                $rolPorUsuario->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return ['respuesta' => false, 'error' => $error];
        }
    }

    public function EditarUsuario($arrayUser){
        DB::beginTransaction();
        try {
            $user =  User::find($arrayUser['id']);
            $user->name = $arrayUser['name'];
            $user->last_name = $arrayUser['last_name'];
            $user->Sede_id = $arrayUser['Sede_id'];;
            Rol_Por_Usuario::where('user_id','=',$user->id)->delete();
            $user->save();
            foreach ($arrayUser['Roles_id'] as $rolid){
                $rolPorUsuario = new Rol_Por_Usuario();
                $rolPorUsuario->Rol_id = $rolid;
                $rolPorUsuario->user_id = $user->id;
                $rolPorUsuario->save();
            }
            DB::commit();

        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return ['respuesta' => false, 'error' => $error];
        }
    }

    public function CambiarContrasenaUsuario($arrayUser){
        DB::beginTransaction();
        try {
            $user =  User::find($arrayUser['id']);
            $user->password = Hash::make($arrayUser['password']);
            $user->save();
            DB::commit();
            return ['respuesta' => true];
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return ['respuesta' => false, 'error' => $error];
        }
    }
}