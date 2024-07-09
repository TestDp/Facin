<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 22/10/2018
 * Time: 9:04 AM
 */

namespace App\Http\Controllers\MInventario;

use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MInventario\EquivalenciaServicio;
use Facin\Negocio\Logica\MInventario\ProductoServicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EquivalenciaController extends Controller
{
    protected  $equivalenciaServicio;
    protected  $productoServicio;

    public function __construct(EquivalenciaServicio $equivalenciaServicio, ProductoServicio $productoServicio){
        $this->equivalenciaServicio = $equivalenciaServicio;
        $this->productoServicio = $productoServicio;
    }

    public function ObtenerEquivalenciasProducto($idproducto)
    {
        $idEmpresa = Auth::user()->Sede->Empresa->id;
          return response()->json(['equivalencias' =>$this->equivalenciaServicio->ObtenerEquivalenciasProducto($idproducto),
              'prodSinEquival'=>$this->productoServicio->ObtenerListProdSinRelOEqui($idEmpresa,$idproducto)]);
    }

    public function EliminarEquivalencia($idproductoP,$idproductoS){
        return response()->json($this->equivalenciaServicio->EliminarEquivalencia($idproductoP,$idproductoS));
    }

    public function GuardarEquivalencia($idProductoP,$idProductoS,$cantidad){
        return response()->json($this->equivalenciaServicio->GuardarEquivalencia($idProductoP,$idProductoS,$cantidad));
    }
}