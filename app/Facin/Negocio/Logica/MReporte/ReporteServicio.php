<?php

namespace App\Facin\Negocio\Logica\MReporte;



use App\Facin\Datos\Repositorio\MReporte\ReporteRepositorio;

class ReporteServicio
{
    protected $reporteRepositorio;
    public function __construct(ReporteRepositorio $reporteRepositorio){
        $this-> reporteRepositorio = $reporteRepositorio;
    }

    public function  ReporteVentasXFecha($idEmpresa,$fechaFiltro){
      return $this-> reporteRepositorio->ReporteVentasXFecha($idEmpresa,$fechaFiltro);
    }

    public function ReporteGastosXFecha($idEmpresa,$fechaFiltro){
        return $this-> reporteRepositorio->ReporteGastosXFecha($idEmpresa,$fechaFiltro);
    }

    public function  ReporteVentasXRangoFechas($idEmpresa,$fechaInicialFiltro,$fechaFinalFiltro){
        return $this-> reporteRepositorio->ReporteVentasXRangoFechas($idEmpresa,$fechaInicialFiltro,$fechaFinalFiltro);
    }
    public function  ReporteGastosXRangoFechas($idEmpresa,$fechaInicialFiltro,$fechaFinalFiltro){
        return $this-> reporteRepositorio->ReporteGastosXRangoFechas($idEmpresa,$fechaInicialFiltro,$fechaFinalFiltro);
    }
    public function ObtenerVentasXProducto($idEmpresa,$fechaFiltroInicial,$fechaFiltroFechaFinal){
        return $this-> reporteRepositorio->ObtenerVentasXProducto($idEmpresa,$fechaFiltroInicial,$fechaFiltroFechaFinal);
    }
}