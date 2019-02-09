<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/12/2018
 * Time: 2:05 PM
 */

namespace App\Facin\Negocio\Logica\MFacturacion;


use App\Facin\Datos\Repositorio\MFacturacion\MedioDePagoRepositorio;

class MedioDePagoServicio
{

    protected  $medioDePagoRepositorio;

    public function __construct(MedioDePagoRepositorio $medioDePagoRepositorio){
        $this->medioDePagoRepositorio = $medioDePagoRepositorio;
    }

    //Metodo para guardar el medio de pago
    public  function GuardarMedioDePago($request)
    {
        return $this->medioDePagoRepositorio->GuardarMedioDePago($request);
    }

    //Metodo para obtener toda  la lista de los estados de la factura
    public  function ObtenerMedioDePago($idMedio){
        return $this->medioDePagoRepositorio->ObtenerMedioDePago($idMedio);
    }

    //Metodo para obtener toda  la lista de los medios de pagos
    public  function ObtenerMediosDePago(){
        return $this->medioDePagoRepositorio->ObtenerMediosDePago();
    }
}