<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/12/2018
 * Time: 12:10 PM
 */

namespace App\Facin\Negocio\Logica\MFacturacion;


use App\Facin\Datos\Repositorio\MFacturacion\EstadoFacturaRepositorio;

class EstadoFacturaServicio
{
    protected  $estadoFacturaRepositorio;

    public function __construct(EstadoFacturaRepositorio $estadoFacturaRepositorio){
        $this->estadoFacturaRepositorio = $estadoFacturaRepositorio;

    }
    //Metodo para guardar el estado de factura
    public  function GuardarEstadoFactura($request)
    {
        return $this->estadoFacturaRepositorio->GuardarEstadoFactura($request);
    }

    //Metodo para obtener toda  la lista de los estados de la factura
    public  function ObtenerEstadosFactura(){
        return $this->estadoFacturaRepositorio->ObtenerEstadosFactura();
    }
}