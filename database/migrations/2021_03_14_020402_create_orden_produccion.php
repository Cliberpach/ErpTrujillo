<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenProduccion extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_produccion', function (Blueprint $table) {
            $table->Increments('id');
            // PROGRAMACION APROBADA
            $table->unsignedInteger('programacion_id')->unsigned();
            $table->unsignedDecimal('cantidad', 15,2);
            $table->date('fecha_produccion'); 
            // DATOS DEL PRODUCTO DE LA PROGRAMACION APROBADA
            $table->unsignedInteger('producto_id')->unsigned();
            $table->string('codigo_producto');     
            $table->string('descripcion_producto');
            // ORDEN DE PRODUCCION
            $table->date('fecha_orden');
            $table->string('version');
            $table->string('codigo');
            $table->time('tiempo_proceso');

            $table->mediumText('observacion')->nullable();
            $table->enum('produccion',['0','1'])->default('0');
            $table->enum('estado',['PRODUCCION','ANULADO', 'ELIMINADO'])->default('PRODUCCION');
            $table->enum('conformidad',['0','1', '2'])->default('0');
            $table->enum('editable',['0','1', '2'])->default('0');
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
        Schema::dropIfExists('orden_produccion');
    }
}
