<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Facturas', function (Blueprint $table) {
            $table->integer('EstadoFactura_id')->unsigned();
            $table->foreign('EstadoFactura_id')->references('id')->on('Tbl_Estados_Facturas');
            $table->integer('Cliente_id')->unsigned();
            $table->foreign('Cliente_id')->references('id')->on('Tbl_Clientes');
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
