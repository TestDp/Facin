<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/12/2018
 * Time: 12:07 PM
 */

namespace App\Facin\Datos\Repositorio\MFacturacion;


use Facin\Datos\Modelos\MFacturacion\EstadoFactura;
use Illuminate\Support\Facades\DB;

class EstadoFacturaRepositorio
{
    //Metodo para guardar el estado de factura
    public  function GuardarEstadoFactura($request)
    {
        DB::beginTransaction();
        try {
            $estadoFactura = new EstadoFactura($request->all());
            $estadoFactura->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    //Metodo para obtener toda  la lista de los estados de la factura
    public  function ObtenerEstadosFactura(){
        return EstadoFactura::all();
    }
}