<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 6/09/2018
 * Time: 3:33 PM
 */

namespace Facin\Negocio\Logica\MSistema;


use Facin\Datos\Repositorio\MSistema\UsuarioRepositorio;

class UsuarioServicio
{

    protected  $usuarioRepositorio;
    public function __construct(UsuarioRepositorio $usuarioRepositorio){
        $this->usuarioRepositorio = $usuarioRepositorio;
    }

    public  function  ObtenerListaUsuarios($idEmpresa,$idUsuario){
        return $this->usuarioRepositorio->ObtenerListaUsuarios($idEmpresa,$idUsuario);
    }
}