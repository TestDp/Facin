<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 26/10/2018
 * Time: 4:35 PM
 */

namespace App\Http\Controllers\MCliente;


use App\Http\Controllers\Controller;
use Facin\Negocio\Logica\MCliente\ClienteServicio;
use Facin\Validaciones\MCliente\ClienteValidaciones;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteController extends Controller
{
    protected  $clienteServicio;
    protected  $clienteValidaciones;
    public function __construct(ClienteServicio $clienteServicio,ClienteValidaciones $clienteValidaciones){
        $this->middleware('auth');
        $this->clienteServicio = $clienteServicio;
        $this->clienteValidaciones = $clienteValidaciones;

    }

    public  function GuardarCliente(Request $request){
        $urlinfo= $request->getPathInfo();
        $request->user()->AutorizarUrlRecurso($urlinfo);
        $this->clienteValidaciones->ValidarFormularioCrear($request->all())->validate();
        $cliente = $request->all();
        $idEmpreesa = Auth::user()->Sede->Empresa->id;
        $cliente['Empresa_id'] = $idEmpreesa;
        return response()->json($this->clienteServicio->GuardarCliente($cliente));

    }
}