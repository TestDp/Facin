<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/08/2018
 * Time: 1:17 PM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MInventario\Proveedor;
use Illuminate\Support\Facades\DB;

class ProveedorRepositorio
{

    public  function GuardarProveedor($request)
    {
        DB::beginTransaction();
        try {
            $proveedor = new Proveedor($request);
            $proveedor->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerListaProveedores($idEmpreesa)
    {
        return Proveedor::where('Empresa_id', '=', $idEmpreesa)->get();
    }
}