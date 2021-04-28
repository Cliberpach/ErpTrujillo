<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLoteArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lote_articulos', function (Blueprint $table) {
            $table->Increments('id');
            
            $table->unsignedInteger('detalle_id')->unsigned();
            $table->string('lote');
            
            $table->unsignedInteger('articulo_id')->unsigned();
            $table->string('codigo_articulo');     
            $table->string('descripcion_articulo');

            $table->unsignedDecimal('cantidad', 15,2); // STOCK - VERDADERO
            $table->unsignedDecimal('cantidad_logica', 15,2); // STOCK - LOGICO
            $table->date('fecha_vencimiento'); //FECHA DE PRODUCCION
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
        Schema::dropIfExists('lote_articulos');
    }
}
