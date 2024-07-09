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

    protected  $productoRepositorio;

    public function __construct(ProductoRepositorio $productoRepositorio){
        $this->productoRepositorio = $productoRepositorio;
    }


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


    //Metodo que me guarda la equivalencia de un producto
    public function GuardarEquivalencia($idProductoP,$idProductoS,$cantidad)
    {
        DB::beginTransaction();
        try {
            $equivalencia =  new Equivalencia();
            $equivalencia->ProductoPrincipal_id = $idProductoP;
            $equivalencia->ProductoSecundario_id = $idProductoS;
            $equivalencia->Cantidad = $cantidad;
            $equivalencia->save();
            DB::commit();
            return array('respuesta' =>true,'ProductoPpal'=>$this->productoRepositorio->ObtenerProducto($idProductoP),'ProductoSec'=>$this->productoRepositorio->ObtenerProducto($idProductoS));

        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }


}