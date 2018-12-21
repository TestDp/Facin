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
            $estadoFactura = new MedioDePago($request->all());
            $estadoFactura->save();
            DB::commit();
            Cache::flush();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    //Metodo para obtener toda  la lista de los medios de pagos
    public  function ObtenerMediosDePago(){
        return MedioDePago::all();
    }
}