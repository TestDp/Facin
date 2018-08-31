<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 31/08/2018
 * Time: 12:49 PM
 */

namespace Facin\Validaciones\MInventario;

use Illuminate\Support\Facades\Validator;

class ProveedorValidaciones
{

    public function ValidarFormularioCrear(array $data)
    {
        return Validator::make($data, [
            'RazonSocial' => 'required|string|max:255',
            'Nit' => 'required|max:255',
            'Nombre' => 'required|max:255',
            'Apellidos' => 'required|max:255',
            'TipoDocumento_id' => 'required|max:255',
            'Identificacion' => 'required|max:255',
            'CorreoElectronico' => 'required|string|email|max:255',
            'Telefono' => 'required|max:255',
            'Celular' => 'required|max:255',
            'Terminos_De_Pago' => 'required|max:255',
            'Descripcion' => 'required|max:255'
        ]);
    }
}