<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoTipoDeProducto extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Productos', function (Blueprint $table) {
            $table->integer('TipoDeProducto_id')->unsigned();
            $table->foreign('TipoDeProducto_id')->references('id')->on('Tbl_Tipos_Productos');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_Productos', function (Blueprint $table) {
            //
        });
    }
}
