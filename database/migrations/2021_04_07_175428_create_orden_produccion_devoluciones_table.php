<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenProduccionDevolucionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_produccion_devoluciones', function (Blueprint $table) {
            $table->Increments('id');
            
            $table->unsignedInteger('detalle_lote_id')->unsigned();
            $table->foreign('detalle_lote_id')
                  ->references('id')->on('orden_produccion_lotes')
                  ->onDelete('cascade');
            $table->unsignedInteger('articulo_id')->unsigned();
            $table->unsignedDecimal('cantidad', 15, 6);
            $table->enum('estado',['0','1'])->nullable(); // MAL 0 - BIEN 1 
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
        Schema::dropIfExists('orden_produccion_devoluciones');
    }
}
