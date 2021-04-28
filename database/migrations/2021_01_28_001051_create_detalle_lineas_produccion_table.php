<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleLineasProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_lineas_produccion', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('linea_produccion_id')->unsigned();
            $table->foreign('linea_produccion_id')
                  ->references('id')->on('lineas_produccion')
                  ->onDelete('cascade');
            $table->unsignedInteger('maquinaria_equipo_id')->unsigned();
            $table->foreign('maquinaria_equipo_id')
                ->references('id')->on('maquinarias_equipos')
                ->onDelete('cascade');
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
        Schema::dropIfExists('detalle_lineas_produccion');
    }
}
