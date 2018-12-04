<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Facturas', function (Blueprint $table) {
            $table->increments('id');
            //$table->dateTime('Fecha');
            $table->string('Comentario')->nullable();
        //$table->integer('MedioDePago_id')->unsigned();
          //  $table->foreign("MedioDePago_id")->references('id')->on('Tbl_Medios_De_Pagos');
            $table->integer('user_id')->unsigned();
            $table->foreign("user_id")->references('id')->on('users');
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
        Schema::dropIfExists('Tbl_Facturas');
    }
}
