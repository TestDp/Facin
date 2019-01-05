<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 8:43 AM
 */

namespace Facin\Datos\Repositorio\MEmpresa;


use Facin\Datos\Modelos\MEmpresa\UnidadDeMedida;
use Illuminate\Support\Facades\DB;

class UnidadDeMedidaRepositorio
{

    public  function GuardarUnidad($unidadMedida)
    {
        DB::beginTransaction();
        try {

            if(isset($unidadMedida['id']))
            {
                $unidad = UnidadDeMedida::find($unidadMedida['id']);
                $unidad->Unidad =$unidadMedida['Unidad'];
                $unidad->Abreviatura =$unidadMedida['Abreviatura'];
                $unidad->Descripcion = $unidadMedida['Descripcion'];
                $unidad->Empresa_id = $unidadMedida['Empresa_id'];
            }else{
                $unidad = new UnidadDeMedida($unidadMedida);
            }
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

    public  function  ObtenerListaUnidadesEmpresa($idEmpreesa)
    {
        return UnidadDeMedida::where('Empresa_id', '=', $idEmpreesa)->get();
    }

    public  function  ObtenerUnidadMedidaXId($idUnidad)
    {
        return UnidadDeMedida::where('id','=',$idUnidad)->get()->first();
    }

}