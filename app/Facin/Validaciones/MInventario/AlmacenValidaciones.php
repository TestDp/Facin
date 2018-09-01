<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 31/08/2018
 * Time: 12:39 PM
 */

namespace Facin\Validaciones\MInventario;

use Illuminate\Support\Facades\Validator;

class AlmacenValidaciones
{

    public function ValidarFormularioCrear(array $data)
    {
        $mensajes = $this->mensajesFormularioCrear();
        return Validator::make($data, [
            'Nombre' => 'required|string|max:255',
            'Ubicacion' => 'required|max:255'
        ],$mensajes);
    }

    public  function  mensajesFormularioCrear(){
        return ['Nombre.required' => 'El nombre es obligatorio',
                'Ubicacion.required' => 'La ubicación es obligatoria'];
    }
}