<?php
/**
 * Created by PhpStorm.
 * User: DPS-C
 * Date: 8/08/2018
 * Time: 12:33 PM
 */

namespace Facin\Datos\Modelos\MInventario;


use Facin\Datos\Modelos\MEmpresa\Empresa;
use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    protected $table = 'Tbl_Categorias';
    protected $fillable =['Nombre','Descripcion','Empresa_id'];

    public function Empresa()
    {
        return $this->belongsTo(Empresa::class,'Empresa_id');
    }
}