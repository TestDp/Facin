<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 5/09/2018
 * Time: 9:09 AM
 */

namespace Facin\Negocio\Logica\MEmpresa;


use Facin\Datos\Repositorio\MEmpresa\SedeRepositorio;

class SedeServicio
{
    protected  $sedeRepositorio;
    public function __construct(SedeRepositorio $sedeRepositorio){
        $this->sedeRepositorio = $sedeRepositorio;
    }

    public  function GuardarSede($Sede){
        return $this->sedeRepositorio->GuardarSede($Sede);
    }
    public  function  ObtenerListaSedes($idEmpreesa){
        return $this->sedeRepositorio->ObtenerListaSedes($idEmpreesa);
    }

    public  function  ObtenerSede($idSede){
        return $this->sedeRepositorio->  ObtenerSede($idSede);
    }

}