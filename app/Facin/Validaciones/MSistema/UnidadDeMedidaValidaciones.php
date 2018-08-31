<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 31/08/2018
 * Time: 4:08 PM
 */

namespace Facin\Validaciones\MSistema;

use Illuminate\Support\Facades\Validator;

class UnidadDeMedidaValidaciones
{

    public function ValidarFormularioCrear(array $data)
    {
        return Validator::make($data, [
            'Unidad' => 'required|string|max:255',
            'Abreviatura' => 'required|max:255',
            'Descripcion' => 'required|max:255'
        ]);
    }
}