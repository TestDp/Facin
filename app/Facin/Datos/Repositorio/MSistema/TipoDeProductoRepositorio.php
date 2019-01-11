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
            if(isset($request['id']))
            {
                $tipoProducto = TipoDeProducto::find($request['id']);
                $tipoProducto->Nombre = $request['Nombre'];
                $tipoProducto->Descripcion = $request['Descripcion'];

            }else {
                $tipoProducto = new TipoDeProducto($request);
            }
            $tipoProducto->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerTipoProducto($idTipo)
    {
        return TipoDeProducto::where('id', '=', $idTipo)->get()->first();
    }

    public  function  ObtenerListaTipoProductos()
    {
        return TipoDeProducto::all();
    }
}