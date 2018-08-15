<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaSedes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Sedes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Nombre');
            $table->string('Direccion');
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
        Schema::dropIfExists('Tbl_Sedes');
    }
}
