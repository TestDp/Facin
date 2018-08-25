<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AgregarAmposProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Proveedores', function (Blueprint $table) {
            $table->integer('Empresa_id')->unsigned();
            $table->foreign('Empresa_id')->references('id')->on('Tbl_Empresas');
            $table->integer('TipoDocumento_id')->unsigned();
            $table->foreign('TipoDocumento_id')->references('id')->on('Tbl_Tipos_Documento');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Tbl_Proveedores', function (Blueprint $table) {
            //
        });
    }
}
