<?php

namespace App\Facin\Datos\Repositorio\MReporte;

use Carbon\Carbon;
use Facin\Datos\Modelos\MFacturacion\Factura;
use Illuminate\Support\Facades\DB;

class ReporteRepositorio
{

    //retorna una lista de las ventas por fecha agrupadas por medio de pago
   public function  ReporteVentasXFecha($idEmpresa,$fechaFiltro){
       $fechaFin = Carbon::parse($fechaFiltro)->addDay()->format('Y-m-d');
       return DB::table('Tbl_Facturas')
           ->join('users', 'Tbl_Facturas.user_id','=','users.id')
           ->join('Tbl_Sedes', 'users.Sede_id','=','Tbl_Sedes.id')
           ->join('Tbl_Medio_De_Pago_X_Factura','Tbl_Facturas.id','=','Tbl_Medio_De_Pago_X_Factura.Factura_id')
           ->groupBy('Tbl_Medio_De_Pago_X_Factura.MedioDePago_id')
           ->select('Tbl_Medio_De_Pago_X_Factura.MedioDePago_id',DB::raw('sum(Tbl_Medio_De_Pago_X_Factura.Valor) as Total'))
           ->where('Tbl_Sedes.Empresa_id', '=', $idEmpresa)
           ->where('Tbl_Facturas.EstadoFactura_id', '=', 2)//estado de factura finalizada
           ->where('Tbl_Facturas.updated_at','<',$fechaFin)
           ->where('Tbl_Facturas.updated_at','>',$fechaFiltro)
           ->get();
   }

   public function ReporteGastosXFecha($idEmpresa,$fechaFiltro){
       $fechaFin = Carbon::parse($fechaFiltro)->addDay()->format('Y-m-d');
       return DB::table('Tbl_Precios_De_Compra')
           ->join('Tbl_Productos_Por_Proveedores', 'Tbl_Precios_De_Compra.ProductoPorProveedor_id','=','Tbl_Productos_Por_Proveedores.id')
           ->join('Tbl_Proveedores', 'Tbl_Productos_Por_Proveedores.Proveedor_id','=','Tbl_Proveedores.id')
           ->join('Tbl_Empresas','Tbl_Empresas.id','=','Tbl_Proveedores.Empresa_id')
           ->groupBy('Tbl_Productos_Por_Proveedores.Proveedor_id','Tbl_Proveedores.RazonSocial')
           ->select('Tbl_Productos_Por_Proveedores.Proveedor_id','Tbl_Proveedores.RazonSocial',DB::raw('sum(Tbl_Precios_De_Compra.Precio) as Total'))
           ->where('Tbl_Empresas.id', '=', $idEmpresa)
           ->where('Tbl_Precios_De_Compra.updated_at','<',$fechaFin)
           ->where('Tbl_Precios_De_Compra.updated_at','>',$fechaFiltro)
           ->get();
   }

    public function  ReporteVentasXRangoFechas($idEmpresa,$fechaInicialFiltro,$fechaFinalFiltro){
        return DB::table('Tbl_Facturas')
            ->join('users', 'Tbl_Facturas.user_id','=','users.id')
            ->join('Tbl_Sedes', 'users.Sede_id','=','Tbl_Sedes.id')
            ->join('Tbl_Medio_De_Pago_X_Factura','Tbl_Facturas.id','=','Tbl_Medio_De_Pago_X_Factura.Factura_id')
            ->select(DB::raw("DATE_FORMAT(Tbl_Facturas.updated_at, '%Y-%m-%d') as created_at"),DB::raw('sum(Tbl_Medio_De_Pago_X_Factura.Valor) as Total'))
            ->groupBy('created_at')
            ->where('Tbl_Sedes.Empresa_id', '=', $idEmpresa)
            ->where('Tbl_Facturas.EstadoFactura_id', '=', 2)//estado de factura finalizada
            ->where('Tbl_Facturas.updated_at','<',$fechaFinalFiltro)
            ->where('Tbl_Facturas.updated_at','>',$fechaInicialFiltro)
            ->get();


/*        DB::table('tbl_asistentesXeventos')
            ->join('tbl_asistentes', 'tbl_asistentesXeventos.Asistente_id','=','tbl_asistentes.id')
            // ->groupBy('tbl_asistentes.Edad')
            ->select(DB::raw("DATE_FORMAT(tbl_asistentes.created_at, '%Y-%m-%d') as created_at"),DB::raw('count(tbl_asistentes.created_at) as cantidad'))
            ->groupBy('created_at')
            ->where('tbl_asistentesXeventos.Evento_id','=',$idEvento)
            ->get();*/


    }

    public function  ReporteGastosXRangoFechas($idEmpresa,$fechaInicialFiltro,$fechaFinalFiltro){
        return DB::table('Tbl_Precios_De_Compra')
            ->join('Tbl_Productos_Por_Proveedores', 'Tbl_Precios_De_Compra.ProductoPorProveedor_id','=','Tbl_Productos_Por_Proveedores.id')
            ->join('Tbl_Proveedores', 'Tbl_Productos_Por_Proveedores.Proveedor_id','=','Tbl_Proveedores.id')
            ->join('Tbl_Empresas','Tbl_Empresas.id','=','Tbl_Proveedores.Empresa_id')
            ->select(DB::raw("DATE_FORMAT(Tbl_Precios_De_Compra.updated_at, '%Y-%m-%d') as created_at"),DB::raw('sum(Tbl_Precios_De_Compra.Precio) as Total'))
            ->groupBy('created_at')
            ->where('Tbl_Empresas.id', '=', $idEmpresa)
            ->where('Tbl_Precios_De_Compra.updated_at','<',$fechaFinalFiltro)
            ->where('Tbl_Precios_De_Compra.updated_at','>',$fechaInicialFiltro)
            ->get();
    }
}