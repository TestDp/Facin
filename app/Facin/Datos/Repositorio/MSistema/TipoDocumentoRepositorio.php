<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 24/08/2018
 * Time: 10:17 AM
 */

namespace Facin\Datos\Repositorio\MSistema;


use Facin\Datos\Modelos\MSistema\TipoDocumento;
use Illuminate\Support\Facades\DB;

class TipoDocumentoRepositorio
{

    public  function GuardarTipoDocumento($request)
    {
        DB::beginTransaction();
        try {
            if(isset($request['id']))
            {
                $tipoDocumento = TipoDocumento::find($request['id']);
                $tipoDocumento->Nombre = $request['Nombre'];
                $tipoDocumento->Descripcion = $request['Descripcion'];

            }else {
                $tipoDocumento = new TipoDocumento($request);
            }
            $tipoDocumento->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerTipoDocumento($idTipo)
    {
        return TipoDocumento::where('id', '=', $idTipo)->get()->first();
    }

    public  function  ObtenerListaTipoDocumentos()
    {
        return TipoDocumento::all();
    }

}