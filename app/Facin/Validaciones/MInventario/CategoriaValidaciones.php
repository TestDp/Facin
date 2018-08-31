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
        return Validator::make($data, [
            'Nombre' => 'required|string|max:255',
            'Descripcion' => 'required|max:255'
        ]);
    }
}