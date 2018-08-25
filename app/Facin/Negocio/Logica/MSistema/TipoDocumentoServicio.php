<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 24/08/2018
 * Time: 10:15 AM
 */

namespace Facin\Negocio\Logica\MSistema;


use Facin\Datos\Modelos\MSistema\TipoDocumento;
use Facin\Datos\Repositorio\MSistema\TipoDocumentoRepositorio;

class TipoDocumentoServicio
{
    protected  $TipoDocumentoRepositorio;
    public function __construct(TipoDocumentoRepositorio $TipoDocumentoRepositorio){
        $this->TipoDocumentoRepositorio = $TipoDocumentoRepositorio;
    }

    public  function GuardarTipoDocumento($request)
    {
         return $this->TipoDocumentoRepositorio->GuardarTipoDocumento($request);
    }

    public  function  ObtenerListaTipoDocumentos()
    {
        return $this->TipoDocumentoRepositorio->ObtenerListaTipoDocumentos();
    }
}