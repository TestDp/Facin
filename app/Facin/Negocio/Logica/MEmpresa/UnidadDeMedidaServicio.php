<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 8:52 AM
 */

namespace Facin\Negocio\Logica\MEmpresa;


use Facin\Datos\Repositorio\MEmpresa\UnidadDeMedidaRepositorio;

class UnidadDeMedidaServicio
{
    protected  $unidadDeMedidaRepositorio;
    public function __construct(UnidadDeMedidaRepositorio $unidadDeMedidaRepositorio){
        $this->unidadDeMedidaRepositorio = $unidadDeMedidaRepositorio;
    }

    public  function GuardarUnidad($unidadMedida){
       return $this->unidadDeMedidaRepositorio->GuardarUnidad($unidadMedida);
    }

    public  function  ObtenerListaUnidades()
    {
        return $this->unidadDeMedidaRepositorio->ObtenerListaUnidades();
    }

    public  function  ObtenerListaUnidadesEmpresa($idEmpreesa)
    {
        return $this->unidadDeMedidaRepositorio->ObtenerListaUnidadesEmpresa($idEmpreesa);
    }

}