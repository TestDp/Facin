<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/10/2018
 * Time: 4:33 PM
 */

namespace Facin\Datos\Repositorio\MCliente;


use Facin\Datos\Modelos\MCliente\Cliente;
use Illuminate\Support\Facades\DB;

class ClienteRepositorio
{

    public  function GuardarCliente($cliente)
    {
        DB::beginTransaction();
        try {
            $sede = new Cliente($cliente);
            $sede->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }
}