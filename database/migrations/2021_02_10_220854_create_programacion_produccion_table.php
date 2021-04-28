<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProgramacionProduccionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('programacion_produccion', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('producto_id')->unsigned();
            $table->foreign('producto_id')
                  ->references('id')->on('productos')
                  ->onDelete('cascade');
            // $table->date('fecha_creacion');
            $table->date('fecha_produccion');
            $table->date('fecha_termino')->nullable();            
            // $table->unsignedInteger('cantidad_programada');
            // $table->unsignedInteger('cantidad_producida')->nullable();
            $table->unsignedInteger('cantidad_programada');
            $table->mediumText('observacion')->nullable();
            // $table->BigInteger('usuario_id');
            $table->enum('estado',['VIGENTE','PRODUCCION','TERMINADO','ANULADO'])->default('VIGENTE');
            $table->enum('produccion',['0','1'])->default('0');
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
        Schema::dropIfExists('programacion_produccion');
    }
}
