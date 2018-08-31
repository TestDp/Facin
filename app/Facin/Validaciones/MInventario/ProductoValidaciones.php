<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 31/08/2018
 * Time: 3:28 PM
 */

namespace Facin\Validaciones\MInventario;

use Illuminate\Support\Facades\Validator;

class ProductoValidaciones
{

    public function ValidarFormularioCrear(array $data)
    {
        return Validator::make($data, [
            'Codigo' => 'required|string|max:255',
            'Nombre' => 'required|max:255',
            'Nombre' => 'required|max:255',
            'Precio' => 'required|max:255',
            'PrecioSinIva' => 'required|max:255',
            'Cantidad' => 'required|max:255',
            'Almacen_id' => 'required|max:255',
            'Categoria_id' => 'required|max:255',
            'UnidadDeMedida_id' => 'required|max:255',
            'Proveedor_id' => 'required|max:255'
        ]);
    }
}