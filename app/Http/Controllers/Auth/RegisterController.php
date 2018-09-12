<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Facin\Datos\Modelos\MEmpresa\Empresa;
use Facin\Datos\Modelos\MEmpresa\Sede;
use Facin\Datos\Modelos\MSistema\Rol;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return: redirecciona al usuario al inicio de sesión
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();
        event(new Registered($user = $this->create($request->all())));
        return view('auth.RespuestaRegistro',['respuesta'=>true]);
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => 'required|string|max:255',
            'last_name' => 'required|max:255',
            'username' => 'required|max:15|unique:users',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'CorreoElectronico'=>'required|string|email|max:255',
            'SitioWeb' =>'required|string|url|max:255'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        DB::beginTransaction();
        try {
            $empresa = Empresa::create([
                'NitEmpresa'=> $data['NitEmpresa'],
                'TipoDocumento'=> 'CC',
                'IdentificacionRepresentante'=> $data['IdentificacionRepresentante'],
                'RazonSocial'=> $data['RazonSocial'],
                'Direccion'=> $data['Direccion'],
                'Telefono'=> $data['Telefono'],
                'CorreoElectronico'=> $data['CorreoElectronico'],
                'SitioWeb'=> $data['SitioWeb'],
                'EsActiva'=> 1,
                'LogoEmpresa'=> 'Imagen logo Empresa'
            ]);
            $sede = Sede::create([
                'Nombre' => 'Sede '.$data['RazonSocial'],
                'Direccion' => $data['Direccion'],
                'Telefono' => $data['Telefono'],
                'Empresa_id' =>$empresa->id
            ]);
            $data['CodigoConfirmacion'] = str_random(25);
            $user = User::create([
                'name' => $data['name'],
                'last_name' => $data['last_name'],
                'username' => $data['username'],
                'email' => $data['email'],
                'password' => Hash::make($data['password']),
                'Sede_id' =>$sede->id,
                'CodigoConfirmacion' => $data['CodigoConfirmacion']
            ]);
            $user
                ->roles()
                ->attach(Rol::where('Nombre', 'Admin')->first());
            DB::commit();
            Mail::send('Correos.ConfirmarCorreo', $data, function($message) use ($data) {
                $message->to($data['email'], $data['name'])->subject('Por favor confirma tu correo');
            });
            return $user;
        } catch (\Exception $e) {
            $error = $e->getMessage();
            DB::rollback();
            return ['respuesta' => false, 'error' => $error];
        }
    }



}
