<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CrearTablaProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Tbl_Productos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('Codigo');
            $table->string('Nombre');
            $table->double('Precio');
            $table->integer('Cantidad');
            $table->string('Imagen_Producto');
            $table->integer('Categoria_id')->unsigned();
            $table->foreign('Categoria_id')->references('id')->on('Tbl_Categorias');
            $table->integer('Proveedor_id')->unsigned();
            $table->foreign('Proveedor_id')->references('id')->on('Tbl_Proveedores');
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
        Schema::dropIfExists('Tbl_Productos');
    }
}
