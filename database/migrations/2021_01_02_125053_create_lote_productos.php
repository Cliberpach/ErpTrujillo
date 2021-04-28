<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoteProductos extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lote_productos', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('codigo');
            // $table->unsignedInteger('producto_id');
            // $table->foreign('producto_id')->references('id')->on('productos')->onDelete('cascade');
            $table->unsignedInteger('orden_id')->unsigned();
            
            $table->unsignedInteger('producto_id')->unsigned();
            $table->string('codigo_producto');     
            $table->string('descripcion_producto');

            $table->unsignedDecimal('cantidad', 15,2); // STOCK - VERDADERO
            $table->unsignedDecimal('cantidad_logica', 15,2); // STOCK - LOGICO

            $table->date('fecha_vencimiento'); //FECHA DE PRODUCCION
            $table->date('fecha_entrega');
            $table->mediumText('observacion')->nullable();

            $table->char('confor_almacen')->nullable();
            $table->char('confor_produccion')->nullable();

            $table->enum('estado',['0','1'])->default('1');
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
        Schema::dropIfExists('lote_productos');
    }
}
