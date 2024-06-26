<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/12/2018
 * Time: 2:02 PM
 */

namespace App\Facin\Datos\Repositorio\MFacturacion;


use Facin\Datos\Modelos\MFacturacion\MedioDePago;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class MedioDePagoRepositorio
{
    //Metodo para guardar el medio de pago
    public  function GuardarMedioDePago($request)
    {
        DB::beginTransaction();
        try {
            if(isset($request['id']))
            {
                $medioDePago = MedioDePago::find($request['id']);
                $medioDePago->Nombre = $request['Nombre'];
                $medioDePago->Descripcion = $request['Descripcion'];

            }else {
                $medioDePago = new MedioDePago($request->all());
            }
            $medioDePago->save();
            DB::commit();
            Cache::flush();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerMedioDePago($idMedio)
    {
        return MedioDePago::where('id', '=', $idMedio)->get()->first();
    }

    //Metodo para obtener toda  la lista de los medios de pagos
    public  function ObtenerMediosDePago(){
        return MedioDePago::all();
    }
}