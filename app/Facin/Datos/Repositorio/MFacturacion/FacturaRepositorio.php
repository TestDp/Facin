<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 30/10/2018
 * Time: 1:04 PM
 */

namespace Facin\Datos\Repositorio\MFacturacion;

use Facin\Datos\Modelos\MFacturacion\Factura;
use Illuminate\Support\Facades\DB;

class FacturaRepositorio
{

    public  function CrearFacutra($pedido)
    {
        DB::beginTransaction();
        try {
            //$factura = new Factura($pedido);
            $pedido->save();
            DB::commit();
            $pedido->EstadoFactura;
            $pedido->Cliente;
            return $pedido;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    //retorna una lista de pedidos filtrados por sede y estado
    public function ListaPedidosXSedeXEstados($idSede,$idEstado)
    {
        $pedidos = DB::table('Tbl_Facturas')
            ->join('users', 'users.id', '=', 'Tbl_Facturas.user_id')
            ->join('Tbl_Sedes', 'Tbl_Sedes.id', '=', 'users.Sede_id')
            ->join('Tbl_Estados_Facturas', 'Tbl_Estados_Facturas.id', '=', 'Tbl_Facturas.EstadoFactura_id')
            ->join('Tbl_Clientes', 'Tbl_Clientes.id', '=', 'Tbl_Facturas.Cliente_id')
            ->select('Tbl_Facturas.*','Tbl_Clientes.Nombre','Tbl_Clientes.Apellidos','Tbl_Estados_Facturas.Nombre as nombreEstado')
            ->where('Tbl_Sedes.id', '=', $idSede)
            ->where('Tbl_Facturas.EstadoFactura_id', '=', $idEstado)
            ->orderBy('Tbl_Facturas.id')
            ->get();
        return $pedidos;
    }

}