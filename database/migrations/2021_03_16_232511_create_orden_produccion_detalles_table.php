<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOrdenProduccionDetallesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orden_produccion_detalles', function (Blueprint $table) {
            $table->Increments('id');
            
            $table->unsignedInteger('orden_id')->unsigned();
            $table->foreign('orden_id')
                  ->references('id')->on('orden_produccion')
                  ->onDelete('cascade');

            $table->unsignedInteger('articulo_id')->unsigned();
            $table->foreign('articulo_id')
                ->references('id')->on('producto_detalles')
                ->onDelete('cascade');

            $table->unsignedDecimal('cantidad_produccion', 15, 6);
            $table->string('cantidad_produccion_completa');
            $table->unsignedDecimal('cantidad_excedida', 15, 6);
            $table->enum('completado',['0','1'])->default('0');
            

            // $table->unsignedInteger('almacen_correcto_id')->unsigned()->nullable();
            // $table->foreign('almacen_correcto_id')
            //         ->references('id')->on('almacenes')
            //         ->onDelete('cascade');

            // $table->unsignedDecimal('cantidad_devuelta_correcta', 15, 6)->nullable();
            // $table->mediumText('observacion_correcta')->nullable();
            
            // $table->unsignedInteger('almacen_incorrecto_id')->unsigned()->nullable();
            // $table->foreign('almacen_incorrecto_id')
            //         ->references('id')->on('almacenes')
            //         ->onDelete('cascade');
                    
            // $table->unsignedDecimal('cantidad_devuelta_incorrecta', 15, 6)->nullable();
            // $table->mediumText('observacion_incorrecta')->nullable();
            // $table->BigInteger('operacion')->nullable();
            
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
        Schema::dropIfExists('orden_produccion_detalles');
    }
}
