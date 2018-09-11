<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoRecursosistemapadreId extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Recursos_Sistemas', function (Blueprint $table) {
            $table->integer('RecursoSistemaPadre_id')->nullable()->unsigned();
            $table->foreign('RecursoSistemaPadre_id')->references('id')->on('Tbl_Recursos_Sistemas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_Recursos_Sistemas', function (Blueprint $table) {
            //
        });
    }
}
