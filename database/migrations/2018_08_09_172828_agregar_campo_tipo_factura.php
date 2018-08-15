<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoTipoFactura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Facturas', function (Blueprint $table) {
            $table->integer('TipoDeFactura_id')->unsigned();
            $table->foreign("TipoDeFactura_id")->references('id')->on('Tbl_Tipos_De_Facturas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_Facturas', function (Blueprint $table) {
            //
        });
    }
}
