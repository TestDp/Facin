<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 31/08/2018
 * Time: 7:01 PM
 */

namespace Facin\Validaciones\MInventario;

use Illuminate\Support\Facades\Validator;

class InventarioValidaciones
{

    public function ValidarFormularioCrear(array $data)
    {
        $mensajes = $this->mensajesFormularioCrear();
        return Validator::make($data, [
            'Producto_id' => 'required|string|max:255',
            'Precio' => 'required|max:255',
            'Cantidad' => 'required|max:255',
            'NumFacturaProvedor' => 'required|max:255'

        ],$mensajes);
    }

    public  function  mensajesFormularioCrear(){
        return ['Producto_id.required' => 'El producto es obligatorio',
            'Precio.required' => 'El precio de compra es obligatorio',
            'Cantidad.required' => 'La cantidad minima es obligatoria',
            'NumFacturaProvedor.required' => 'El número de factura es obligatoria'
            ];
    }
}