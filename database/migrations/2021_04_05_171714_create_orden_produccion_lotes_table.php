<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenProduccionLotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_produccion_lotes', function (Blueprint $table) {
            $table->Increments('id');
            
            $table->unsignedInteger('orden_produccion_detalle_id')->unsigned();
            $table->foreign('orden_produccion_detalle_id')
                  ->references('id')->on('orden_produccion_detalles')
                  ->onDelete('cascade');
                  
            $table->unsignedInteger('lote_articulo_id')->unsigned();
            $table->foreign('lote_articulo_id')
                ->references('id')->on('lote_articulos')
                ->onDelete('cascade');
            $table->unsignedDecimal('cantidad', 15,2);
            $table->enum('tipo_cantidad',['PRODUCCION','EXCEDIDA']);

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
        Schema::dropIfExists('orden_produccion_lotes');
    }
}
