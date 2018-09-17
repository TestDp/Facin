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
        $mensajes = $this->mensajesFormularioCrear();
        return Validator::make($data, [
            'Codigo' => 'required|string|max:255',
            'Nombre' => 'required|max:255',
            'Precio' => 'required|max:255',
            'PrecioSinIva' => 'required|max:255',
            'TipoDeProducto_id' => 'required|max:255',
            'Almacen_id' => 'required|max:255',
            'Categoria_id' => 'required|max:255',
            'UnidadDeMedida_id' => 'required|max:255',
          //  'Proveedor_id' => 'required|max:255'
        ],$mensajes);
    }

    public function ValidarFormularioCrearConProveedor(array $data)
    {
        $mensajes = $this->mensajesFormularioCrear();
        return Validator::make($data, [
            'Codigo' => 'required|string|max:255',
            'Nombre' => 'required|max:255',
            'Precio' => 'required|max:255',
            'PrecioSinIva' => 'required|max:255',
            'TipoDeProducto_id' => 'required|max:255',
            'Almacen_id' => 'required|max:255',
            'Categoria_id' => 'required|max:255',
            'UnidadDeMedida_id' => 'required|max:255',
            'Proveedor_id' => 'required|max:255'
        ],$mensajes);
    }
    public  function  mensajesFormularioCrear(){
        return ['Codigo.required' => 'El código es obligatorio',
            'Nombre.required' => 'El nombre es obligatorio',
            'Precio.required' => 'El precio de venta es obligatorio',
            'PrecioSinIva.required' => 'EL costo es obligatorio',
            'TipoDeProducto_id.required' => 'El tipo de producto es obligatorio',
            'Almacen_id.required' => 'EL almacen es obligatorio',
            'Categoria_id.required' => 'La categoria es obligatoria',
            'UnidadDeMedida_id.required' => 'La unidad de medida es obligatoria',
            'Proveedor_id.required' => 'El proveedor es obligatorio'];
    }
}