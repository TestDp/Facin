<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 9/08/2018
 * Time: 10:36 AM
 */

namespace Facin\Datos\Modelos\MEmpresa;


use Facin\Datos\Modelos\MInventario\Categoria;
use Facin\Datos\Modelos\MInventario\Proveedor;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'Tbl_Empresas';
    protected $fillable =['NitEmpresa','TipoDocumento','IdentificacionRepresentante','RazonSocial',
                            'Direccion','Telefono','CorreoElectronico','SitioWeb','EsActiva','LogoEmpresa'];

    public function Sedes(){
        return $this->hasMany(Sede::class,'Empresa_id','id');
    }

    public function Proveedores(){
        return $this->hasMany(Proveedor::class,'Empresa_id','id');
    }

    public function Categorias(){
        return $this->hasMany(Categoria::class,'Empresa_id','id');
    }
}