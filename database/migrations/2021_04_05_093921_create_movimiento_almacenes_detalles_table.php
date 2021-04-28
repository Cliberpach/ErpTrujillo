<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientoAlmacenesDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_almacenes_detalles', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('movimiento_almacen_id')->unsigned();
            $table->unsignedInteger('articulo_id')->unsigned();
            $table->unsignedDecimal('cantidad', 15,2);
            $table->string('lote');
            $table->date('fecha_vencimiento');
            $table->enum('estado',['ACTIVO','ANULADO'])->default('ACTIVO');

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
        Schema::dropIfExists('movimiento_almacenes_detalles');
    }
}
