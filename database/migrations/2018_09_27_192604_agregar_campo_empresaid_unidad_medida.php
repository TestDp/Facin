<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarCampoEmpresaidUnidadMedida extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Unidades_De_Medidas', function (Blueprint $table) {
            $table->integer('Empresa_id')->unsigned();
            $table->foreign('Empresa_id')->references('id')->on('Tbl_Empresas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_Unidades_De_Medidas', function (Blueprint $table) {
            //
        });
    }
}
