<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 5/09/2018
 * Time: 1:34 PM
 */

namespace Facin\Datos\Repositorio\MSistema;


use Facin\Datos\Modelos\MSistema\RecursoSistemaPorRol;
use Facin\Datos\Modelos\MSistema\Rol;
use Illuminate\Support\Facades\DB;

class RolRepositorio
{
    public  function GuardarRol($Rol)
    {
        DB::beginTransaction();
        try {
            $rol = new Rol($Rol);
            $rol->save();
            foreach ($Rol['idRecurso'] as $idRecurso){
                $recursoSistemaPorRol = new RecursoSistemaPorRol();
                $recursoSistemaPorRol->Rol_id = $rol->id;
                $recursoSistemaPorRol->RecursoSistema_id = $idRecurso;
                $recursoSistemaPorRol->save();
            }
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerListaRoles($idEmpreesa)
    {
        return Rol::where('Empresa_id', '=', $idEmpreesa)->get();
    }
}