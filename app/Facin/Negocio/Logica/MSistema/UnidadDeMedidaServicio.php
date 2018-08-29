<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 27/08/2018
 * Time: 8:52 AM
 */

namespace Facin\Negocio\Logica\MSistema;


use Facin\Datos\Repositorio\MSistema\UnidadDeMedidaRepositorio;

class UnidadDeMedidaServicio
{
    protected  $unidadDeMedidaRepositorio;
    public function __construct(UnidadDeMedidaRepositorio $unidadDeMedidaRepositorio){
        $this->unidadDeMedidaRepositorio = $unidadDeMedidaRepositorio;
    }

    public  function GuardarUnidad($request){
       return $this->unidadDeMedidaRepositorio->GuardarUnidad($request);
    }

    public  function  ObtenerListaUnidades()
    {
        return $this->unidadDeMedidaRepositorio->ObtenerListaUnidades();
    }
}