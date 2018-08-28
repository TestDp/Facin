<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreaarTablaPreciosDecCompra extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Precios_De_Compra', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Cantidad');
            $table->double('Precio');
            $table->string('NumFacturaProvedor');
            $table->integer('ProductoPorProveedor_id')->unsigned();
            $table->foreign('ProductoPorProveedor_id')->references('id')->on('Tbl_Productos_Por_Proveedores');
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
        Schema::dropIfExists('Tbl_Precios_De_Compra');
    }
}
