<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProductosProveedores extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Productos_Por_Proveedores', function (Blueprint $table) {
            $table->increments('id');
            $table->double('Cantidad');
            $table->integer('Proveedor_id')->unsigned();
            $table->foreign('Proveedor_id')->references('id')->on('Tbl_Proveedores');
            $table->integer('Producto_id')->unsigned();
            $table->foreign('Producto_id')->references('id')->on('Tbl_Productos');
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
        Schema::dropIfExists('Tbl_Productos_Por_Proveedores');
    }
}
