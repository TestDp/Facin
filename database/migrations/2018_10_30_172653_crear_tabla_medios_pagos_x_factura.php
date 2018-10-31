<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaMediosPagosXFactura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Medio_De_Pago_X_Factura', function (Blueprint $table) {
            $table->increments('id');
            $table->double('Valor');
            $table->integer('MedioDePago_id')->unsigned();
            $table->foreign("MedioDePago_id")->references('id')->on('Tbl_Medios_De_Pagos');
            $table->integer('Factura_id')->unsigned();
            $table->foreign('Factura_id')->references('id')->on('Tbl_Facturas');
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
        Schema::dropIfExists('Tbl_Medio_De_Pago_X_Factura');
    }
}
