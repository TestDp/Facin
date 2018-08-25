<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 24/08/2018
 * Time: 9:54 PM
 */

namespace Facin\Negocio\Logica\MInventario;


use Facin\Datos\Repositorio\MInventario\CategoriaRepositorio;

class CategoriaServicio
{
    protected  $categoriaRepositorio;
    public function __construct(CategoriaRepositorio $categoriaRepositorio){
        $this->categoriaRepositorio = $categoriaRepositorio;
    }

    public  function GuardarCategoria($Categoria){
        return $this->categoriaRepositorio->GuardarCategoria($Categoria);
    }

    public  function  ObtenerListaCategorias($idEmpreesa)
    {
         return $this->categoriaRepositorio->ObtenerListaCategorias($idEmpreesa);
    }
}