<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Proveedores', function (Blueprint $table) {
            $table->string("Apellidos");
            $table->string('Nit');
            $table->string('Identificacion');
            $table->string('CorreoElectronico');
            $table->string('Telefono');
            $table->string('Celular');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_Proveedores', function (Blueprint $table) {
            //
        });
    }
}
