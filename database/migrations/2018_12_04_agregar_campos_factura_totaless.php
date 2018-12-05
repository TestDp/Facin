<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CamposFacturaTotaless extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Tbl_Facturas', function (Blueprint $table) {
            $table->integer('CantidadTotal');
            $table->double('VentaTotal');
            $table->double('DescuentoTotal');
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
