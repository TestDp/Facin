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

    public  function  ObtenerUsuario($idUsuario){
        return $this->usuarioRepositorio->ObtenerUsuario($idUsuario);
    }

    public function GuardarUsuario($arrayUser){
        return $this->usuarioRepositorio->GuardarUsuario($arrayUser);
    }
    public function EditarUsuario($arrayUser){
        return $this->usuarioRepositorio->EditarUsuario($arrayUser);
    }

    public function CambiarContrasenaUsuario($arrayUser){
        return $this->usuarioRepositorio->CambiarContrasenaUsuario($arrayUser);
    }
}