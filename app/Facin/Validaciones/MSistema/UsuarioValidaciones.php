<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 6/09/2018
 * Time: 5:35 PM
 */

namespace Facin\Validaciones\MSistema;
use Illuminate\Support\Facades\Validator;

class UsuarioValidaciones
{
    public function ValidarFormularioCrear(array $data)
    {
        $mensajes = $this->mensajesFormularioCrear();
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'Roles_id' => 'required|max:255',
            'Sede_id' => 'required|string|max:255'
        ],$mensajes);
    }

    public  function  mensajesFormularioCrear(){
        return ['name.required' => 'El nombre es obligatorio',
                'last_name.required' => 'El apellido es obligatorio',
                'username.required' => 'El usuario es obligatorio',
                'email.required' => 'El correo electrónico es obligatorio',
                'password.required' => 'La contraseña es obligatoria',
                'Roles_id.required' => 'Los roles son obligatorios',
                'Sede_id.required' => 'La sede es obligatoria'];
    }
}