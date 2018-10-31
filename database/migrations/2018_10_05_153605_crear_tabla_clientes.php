<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaClientes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Clientes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Identificacion');
            $table->string("Nombre");
            $table->string("Apellidos");
            $table->string('CorreoElectronico');
            $table->string('Telefono');
            $table->integer('Empresa_id')->unsigned();
            $table->foreign('Empresa_id')->references('id')->on('Tbl_Empresas');
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
        Schema::dropIfExists('Tbl_Clientes');
    }
}
