<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 31/08/2018
 * Time: 11:44 AM
 */

namespace Facin\Validaciones\MInventario;

use Illuminate\Support\Facades\Validator;

class CategoriaValidaciones
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