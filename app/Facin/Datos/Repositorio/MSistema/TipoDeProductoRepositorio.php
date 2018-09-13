<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 12/09/2018
 * Time: 1:14 PM
 */

namespace Facin\Datos\Repositorio\MSistema;

use Facin\Datos\Modelos\MSistema\TipoDeProducto;
use Illuminate\Support\Facades\DB;

class TipoDeProductoRepositorio
{
    public  function GuardarTipoProducto($request)
    {
        DB::beginTransaction();
        try {
            $tipoProducto = new TipoDeProducto($request->all());
            $tipoProducto->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerListaTipoProductos()
    {
        return TipoDeProducto::all();
    }
}