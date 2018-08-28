<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaAlmacenes extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Almacenes', function (Blueprint $table) {
            $table->increments('id');
            $table->string("Nombre");
            $table->string('Ubicacion');
            $table->integer('Sede_id')->unsigned();
            $table->foreign('Sede_id')->references('id')->on('Tbl_Sedes');
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
        Schema::dropIfExists('Tbl_Almacenes');
    }
}
