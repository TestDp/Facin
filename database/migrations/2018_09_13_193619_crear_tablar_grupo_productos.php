<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablarGrupoProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Grupo_De_Productos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ProductoPrincipal_id')->unsigned();
            $table->foreign('ProductoPrincipal_id')->references('id')->on('Tbl_Productos');
            $table->integer('ProductoSecundario_id')->unsigned();
            $table->foreign('ProductoSecundario_id')->references('id')->on('Tbl_Productos');
            $table->integer('Cantidad');
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
        Schema::dropIfExists('Tbl_Grupo_De_Productos');
    }
}
