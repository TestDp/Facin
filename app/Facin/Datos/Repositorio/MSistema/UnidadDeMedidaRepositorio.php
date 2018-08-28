<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 8:43 AM
 */

namespace Facin\Datos\Repositorio\MSistema;


use Facin\Datos\Modelos\MSistema\UnidadDeMedida;
use Illuminate\Support\Facades\DB;

class UnidadDeMedidaRepositorio
{

    public  function GuardarUnidad($request)
    {
        DB::beginTransaction();
        try {
            $unidad = new UnidadDeMedida($request->all());
            $unidad->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerListaUnidades()
    {
        return UnidadDeMedida::all();
    }
}