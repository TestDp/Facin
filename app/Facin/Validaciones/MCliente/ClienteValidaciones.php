<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/10/2018
 * Time: 4:55 PM
 */

namespace Facin\Validaciones\MCliente;
use Illuminate\Support\Facades\Validator;

class ClienteValidaciones
{

    public function ValidarFormularioCrear(array $data)
    {
        $mensajes = $this->mensajesFormularioCrear();

        return Validator::make($data, [
            'Nombre' => 'required|string|max:255',
            'Apellidos' => 'required|string|max:255',
            'Identificacion' => 'required|string|max:255',
            'CorreoElectronico' => 'required|string|email|max:255',
            'Telefono' => 'required|max:255'
        ],$mensajes);
    }

    public  function  mensajesFormularioCrear(){
        return ['Nombre.required' => 'El nombre es obligatorio',
                'Apellidos.required' => 'Los apelligos son obligatorios',
                'Identificacion.required' => 'La identificacion es obligatoria',
                'CorreoElectronico.required' => 'El correo electrónico es obligatorio',
                'CorreoElectronico.email' => 'El correo debe tener un formato válido',
                'Telefono.required' => 'El Teléfono es obligatorio'];
    }
}