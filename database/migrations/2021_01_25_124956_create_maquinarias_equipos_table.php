<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaquinariasEquiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('maquinarias_equipos', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('tipo');
            $table->string('nombre', 200);
            $table->string('serie', 50)->nullable();
            $table->string('tipocorriente')->nullable();
            $table->string('caracteristicas', 200)->nullable();
            $table->string('ruta_imagen')->nullable();
            $table->string('nombre_imagen')->nullable();
            $table->string('vidautil', 50)->nullable();
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
        Schema::dropIfExists('maquinarias_equipos');
    }
}
