<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 21/08/2018
 * Time: 1:17 PM
 */

namespace Facin\Datos\Repositorio\MInventario;


use Facin\Datos\Modelos\MInventario\Proveedor;
use Illuminate\Support\Facades\DB;

class ProveedorRepositorio
{

    public  function GuardarProveedor($request)
    {
        DB::beginTransaction();
        try {
            if(isset($request['id']))
            {
                $proveedor = Proveedor::find($request['id']);
                $proveedor->RazonSocial = $request['RazonSocial'];
                $proveedor->Nit = $request['Nit'];
                $proveedor->Nombre = $request['Nombre'];
                $proveedor->Apellidos = $request['Apellidos'];
                $proveedor->TipoDocumento_id = $request['TipoDocumento_id'];
                $proveedor->Identificacion = $request['Identificacion'];
                $proveedor->CorreoElectronico = $request['CorreoElectronico'];
                $proveedor->Telefono = $request['Telefono'];
                $proveedor->Celular = $request['Celular'];
                $proveedor->Terminos_De_Pago = $request['Terminos_De_Pago'];
                $proveedor->Descripcion = $request['Descripcion'];

            }else {
                $proveedor = new Proveedor($request);
            }
            $proveedor->save();
            DB::commit();
            return true;
        } catch (\Exception $e) {

            $error = $e->getMessage();
            DB::rollback();
            return $error;
        }
    }

    public  function  ObtenerProveedor($idProveedor)
    {
        return Proveedor::where('id', '=', $idProveedor)->get()->first();
    }

    public  function  ObtenerListaProveedores($idEmpreesa)
    {
        return Proveedor::where('Empresa_id', '=', $idEmpreesa)->get();
    }
}