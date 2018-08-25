<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 24/08/2018
 * Time: 9:54 PM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MInventario\Categoria;
use Illuminate\Support\Facades\DB;

class CategoriaRepositorio
{
    public  function GuardarCategoria($Categoria)
    {
        DB::beginTransaction();
        try {
            $categoria = new Categoria($Categoria);
            $categoria->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerListaCategorias($idEmpreesa)
    {
        return Categoria::where('Empresa_id', '=', $idEmpreesa)->get();
    }
}