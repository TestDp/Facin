<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 1:08 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Facin\Datos\Modelos\MEmpresa\Empresa;
use Facin\Datos\Modelos\MSistema\TipoDocumento;
use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'Tbl_Proveedores';
    protected $fillable =['Nombre','Apellidos','Nit','Identificacion','Descripcion','CorreoElectronico',
        'Telefono','Celular','Terminos_De_Pago','Empresa_id','TipoDocumento_id'];

    public function Empresa()
    {
        return $this->belongsTo(Empresa::class,'Empresa_id');
    }

    public function TipoDocumento()
    {
        return $this->belongsTo(TipoDocumento::class,'Empresa_id');
    }
}