<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/08/2018
 * Time: 1:16 PM
 */

namespace Facin\Negocio\Logica\MInventario;


use Facin\Datos\Repositorio\MInventario\ProveedorRepositorio;

class ProveedorServicio
{
    protected $proveedorRepositorio;

    public function __construct(ProveedorRepositorio $proveedorRepositorio){
        $this->proveedorRepositorio = $proveedorRepositorio;
    }

    public  function GuardarProveedor($request){
        return $this->proveedorRepositorio->GuardarProveedor($request);
    }

    public  function  ObtenerProveedor($idProveedor)
    {
        return $this->proveedorRepositorio->ObtenerProveedor($idProveedor);
    }

    public  function  ObtenerListaProveedores($idEmpreesa)
    {
        return $this->proveedorRepositorio->ObtenerListaProveedores($idEmpreesa);
    }

    public function ObtenerProveedorXIdProducto($idproducto){
        return $this->proveedorRepositorio->ObtenerProveedorXIdProducto($idproducto);
    }
}