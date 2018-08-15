<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaEmpresas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('NitEmpresa');
            $table->string('TipoDocumento');
            $table->string('IdentificacionRepresentante');
            $table->string('RazonSocial');
            $table->string('Direccion');
            $table->string('Telefono');
            $table->string('CorreoElectronico');
            $table->string('SitioWeb');
            $table->boolean('EsActiva');
            $table->string('LogoEmpresa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Tbl_Empresas');
    }
}
