<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/10/2018
 * Time: 4:33 PM
 */

namespace Facin\Negocio\Logica\MCliente;


use Facin\Datos\Repositorio\MCliente\ClienteRepositorio;

class ClienteServicio
{
    protected  $clienteRepositorio;
    public function __construct(ClienteRepositorio $clienteRepositorio){
        $this->clienteRepositorio = $clienteRepositorio;
    }

    public  function GuardarCliente($cliente){
        return $this->clienteRepositorio->GuardarCliente($cliente);
    }

    public  function ObtenerListaClientesXEmpresa($idEmpresa){
        return $this->clienteRepositorio->ObtenerListaClientesXEmpresa($idEmpresa);
    }

}