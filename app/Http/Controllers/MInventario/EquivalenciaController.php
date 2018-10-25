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

class EquivalenciaController extends Controller
{
    protected  $equivalenciaServicio;
    public function __construct(EquivalenciaServicio $equivalenciaServicio){
        $this->equivalenciaServicio = $equivalenciaServicio;
    }

    public function ObtenerEquivalenciasProducto($idproducto)
    {
          return response()->json($this->equivalenciaServicio->ObtenerEquivalenciasProducto($idproducto));
    }

    public function EliminarEquivalencia($idproductoP,$idproductoS){
        return response()->json($this->equivalenciaServicio->EliminarEquivalencia($idproductoP,$idproductoS));
    }
}