<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCamposTablaProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Productos', function (Blueprint $table) {
            $table->double('PrecioSinIva');
            $table->integer('UnidadDeMedida_id')->unsigned();
            $table->foreign('UnidadDeMedida_id')->references('id')->on('Tbl_Unidades_De_Medidas');
            $table->integer('Almacen_id')->unsigned();
            $table->foreign('Almacen_id')->references('id')->on('Tbl_Almacenes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

    }
}
