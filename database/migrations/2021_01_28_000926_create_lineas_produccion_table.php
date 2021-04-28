<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLineasProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lineas_produccion', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nombre_linea',200);
            $table->unsignedInteger('cantidad_personal')->unsigned();
            $table->string('ruta_imagen')->nullable();
            $table->string('nombre_imagen')->nullable();
            $table->string('ruta_archivo_word')->nullable();
            $table->string('archivo_word')->nullable();
            $table->enum('estado',['ACTIVA','ANULADA'])->default('ACTIVA');
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
        Schema::dropIfExists('lineas_produccion');
    }
}
