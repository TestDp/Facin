<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 25/08/2018
 * Time: 2:30 PM
 */

namespace Facin\Negocio\Logica\MInventario;


use Facin\Datos\Repositorio\MInventario\AlmacenRepositorio;

class AlmacenServicio
{
    protected  $almacenRepositorio;
    public function __construct(AlmacenRepositorio $almacenRepositorio){
        $this->almacenRepositorio = $almacenRepositorio;
    }

    public  function GuardarAlmacen($almacen)
    {
        return $this->almacenRepositorio->GuardarAlmacen($almacen);
    }

    public  function  ObtenerListaAlmacenXSede($idSede)
    {
        return $this->almacenRepositorio->ObtenerListaAlmacen($idSede);
    }

    public  function  ObtenerListaAlmacenXEmpresa($idEmpresa)
    {
        return $this->almacenRepositorio->ObtenerListaAlmacenXEmpresa($idEmpresa);
    }

    public  function  ObtenerAlmacenXId($idAlmancen)
    {
        return $this->almacenRepositorio->ObtenerAlmacenXID($idAlmancen);
    }
}