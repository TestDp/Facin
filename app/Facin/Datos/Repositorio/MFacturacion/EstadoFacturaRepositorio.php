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
            if(isset($request['id']))
            {
                $estadoFactura = EstadoFactura::find($request['id']);
                $estadoFactura->Nombre = $request['Nombre'];
                $estadoFactura->Descripcion = $request['Descripcion'];

            }else {
                $estadoFactura = new EstadoFactura($request);
            }
            $estadoFactura->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }
    public  function  ObtenerEstadoFactura($idEstado)
    {
        return EstadoFactura::where('id', '=', $idEstado)->get()->first();
    }

    //Metodo para obtener toda  la lista de los estados de la factura
    public  function ObtenerEstadosFactura(){
        return EstadoFactura::all();
    }
}