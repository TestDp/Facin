<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 9/08/2018
 * Time: 10:36 AM
 */

namespace Facin\Datos\Modelos\MEmpresa;


use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'Tbl_Empresas';
    protected $fillable =['NitEmpresa','TipoDocumento','IdentificacionRepresentante','RazonSocial',
                            'Direccion','Telefono','CorreoElectronico','SitioWeb','EsActiva','LogoEmpresa'];

    public function Sedes(){
        return $this->hasMany(Sede::class,'Empresa_id','id');
    }
}