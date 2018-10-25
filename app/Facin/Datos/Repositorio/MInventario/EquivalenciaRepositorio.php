<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 22/10/2018
 * Time: 8:58 AM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MInventario\Equivalencia;
use Illuminate\Support\Facades\DB;

class EquivalenciaRepositorio
{
    public function ObtenerEquivalenciasProducto($idproducto)
    {
        $listaequivalencia= Equivalencia::where('ProductoPrincipal_id','=',$idproducto)->get();
        foreach ($listaequivalencia as $equivalencia){
            $equivalencia->ProductoPrincipal->UnidadDeMedida;
            $equivalencia->ProductoSecundario->UnidadDeMedida;
        }
        return $listaequivalencia;
    }

    public function EliminarEquivalencia($idproductoP,$idproductoS){
        DB::beginTransaction();
        try {
            $equivalencia =  Equivalencia::where('ProductoPrincipal_id', '=', $idproductoP)->where('ProductoSecundario_id', '=', $idproductoS)->get()->first();
            $equivalencia->delete();
            DB::commit();
            return true;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }
}