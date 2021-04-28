<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetalleGuiasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_guias', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('guia_id')->unsigned();
            $table->foreign('guia_id')
                  ->references('id')->on('guias')
                  ->onDelete('cascade');

            $table->unsignedInteger('articulo_id')->unsigned();
            $table->foreign('articulo_id')
                ->references('id')->on('articulos')
                ->onDelete('cascade');
            $table->unsignedDecimal('cantidad_solicitada',15,6)->nullable();
            $table->unsignedDecimal('cantidad_entregada',15,6)->nullable();
            $table->unsignedDecimal('cantidad_devuelta',15,6)->nullable();
            $table->string('observacion')->nullable();
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
        Schema::dropIfExists('detalle_guias');
    }
}
