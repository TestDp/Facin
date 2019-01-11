<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 12/09/2018
 * Time: 1:14 PM
 */

namespace Facin\Negocio\Logica\MSistema;


use Facin\Datos\Repositorio\MSistema\TipoDeProductoRepositorio;

class TipoDeProductoServicio
{
    protected  $tipoProductoRepositorio;
    public function __construct(TipoDeProductoRepositorio $tipoProductoRepositorio){
        $this->tipoProductoRepositorio = $tipoProductoRepositorio;
    }

    public  function GuardarTipoProducto($request)
    {
        return $this->tipoProductoRepositorio->GuardarTipoProducto($request);
    }

    public  function ObtenerTipoProducto($idTipo)
    {
        return $this->tipoProductoRepositorio->ObtenerTipoProducto($idTipo);
    }

    public  function  ObtenerListaTipoProductos()
    {
        return $this->tipoProductoRepositorio->ObtenerListaTipoProductos();
    }
}