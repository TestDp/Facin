<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaRecursosSistemasPorRol extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Recursos_Sistemas_Por_Rol', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Rol_id')->unsigned();
            $table->foreign("Rol_id")->references('id')->on('Tbl_Roles');
            $table->integer('RecursoSistema_id')->unsigned();
            $table->foreign("RecursoSistema_id")->references('id')->on('Tbl_Recursos_Sistemas');
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
        Schema::dropIfExists('Tbl_Recursos_Sistemas_Por_Rol');
    }
}
