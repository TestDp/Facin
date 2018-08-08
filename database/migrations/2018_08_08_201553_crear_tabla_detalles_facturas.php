<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaDetallesFacturas extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Detalles_Facturas', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Cantidad');
            $table->double('SubTotal');
            $table->double('Descuento');
            $table->integer('Producto_id')->unsigned();
            $table->foreign('Producto_id')->references('id')->on('Tbl_Productos');
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
        Schema::dropIfExists('Tbl_Detalles_Facturas');
    }
}
