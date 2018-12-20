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
    public  function GuardarCategoria($request)
    {
        DB::beginTransaction();
        try {
            if(isset($request['id']))
            {
                $categoria = Categoria::find($request['id']);
                $categoria->Nombre = $request['Nombre'];
                $categoria->Descripcion = $request['Descripcion'];
            }else {
                $categoria = new Categoria($request);
            }
             $categoria->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerCategoria($idCategoria)
    {
        return Categoria::where('id', '=', $idCategoria)->get()->first();
    }

    public  function  ObtenerListaCategorias($idEmpreesa)
    {
        return Categoria::where('Empresa_id', '=', $idEmpreesa)->get();
    }
}