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
        $mensajes = $this->mensajesFormularioCrear();
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
        ],$mensajes);
    }

    public  function  mensajesFormularioCrear(){
        return ['RazonSocial.required' => 'La razon social es obligatoria',
                'Nit.required' => 'El Nit es obligatorio',
                'Nombre.required' => 'El nombre es obligatorio',
                'Apellidos.required' => 'EL apellido es obligatorio',
                'TipoDocumento_id.required' => 'El tipo de documento es obligatorio',
                'Identificacion.required' => 'EL número de documento es obligatorio',
                'CorreoElectronico.required' => 'EL correo es obligatorio',
                'Telefono.required' => 'EL telefono es obligatorio',
                'Celular.required' => 'El celular es obligatorio',
                'Terminos_De_Pago.required' => 'Los terminos son obligatorios',
                'Descripcion.required' => 'La descripción es obligatoria'];
    }
}