<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 25/08/2018
 * Time: 2:30 PM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MInventario\Almacen;
use Illuminate\Support\Facades\DB;

class AlmacenRepositorio
{

    public  function GuardarAlmacen($Almacen)
    {
        DB::beginTransaction();
        try {
            $almacen = new Almacen($Almacen);
            $almacen->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerListaAlmacen($idSede)
    {
        return Almacen::where('Sede_id', '=', $idSede)->get();
    }
}