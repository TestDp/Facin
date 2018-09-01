<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 31/08/2018
 * Time: 4:07 PM
 */

namespace Facin\Validaciones\MSistema;

use Illuminate\Support\Facades\Validator;

class TipoDocumentoValidaciones
{

    public function ValidarFormularioCrear(array $data)
    {
        $mensajes = $this->mensajesFormularioCrear();
        return Validator::make($data, [
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|max:255'
        ],$mensajes);
    }

    public  function  mensajesFormularioCrear(){
        return ['Nombre.required' => 'El nombre es obligatorio',
                'Descripcion.required' => 'La descripción es obligatoria'];
    }
}