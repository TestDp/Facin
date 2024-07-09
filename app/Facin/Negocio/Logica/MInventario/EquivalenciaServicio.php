<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 22/10/2018
 * Time: 9:01 AM
 */

namespace Facin\Negocio\Logica\MInventario;


use Facin\Datos\Repositorio\MInventario\EquivalenciaRepositorio;

class EquivalenciaServicio
{
    protected  $equivalenciaRepositorio;
    public function __construct(EquivalenciaRepositorio $equivalenciaRepositorio){
        $this->equivalenciaRepositorio = $equivalenciaRepositorio;
    }

    public function ObtenerEquivalenciasProducto($idproducto)
    {
        return $this->equivalenciaRepositorio->ObtenerEquivalenciasProducto($idproducto);
    }

    public function EliminarEquivalencia($idproductoP,$idproductoS){
        return $this->equivalenciaRepositorio->EliminarEquivalencia($idproductoP,$idproductoS);
    }

    public function GuardarEquivalencia($idProductoP,$idProductoS,$cantidad)
    {
        return $this->equivalenciaRepositorio->GuardarEquivalencia($idProductoP,$idProductoS,$cantidad);
    }
}