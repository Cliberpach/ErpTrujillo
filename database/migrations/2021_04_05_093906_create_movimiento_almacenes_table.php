<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMovimientoAlmacenesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('movimiento_almacenes', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('orden_produccion_detalle_id')->unsigned()->nullable();
            $table->unsignedInteger('almacen_inicio_id')->unsigned()->nullable();
            $table->unsignedInteger('almacen_final_id')->unsigned();
            $table->unsignedDecimal('cantidad', 15,2);
            $table->string('nota');
            $table->mediumText('observacion');
            $table->unsignedInteger('usuario_id')->unsigned(); 
            $table->enum('movimiento',['SALIDA','INGRESO']);
            $table->unsignedInteger('articulo_id')->unsigned();
            $table->unsignedInteger('documento_compra_id')->unsigned()->nullable();
            $table->unsignedInteger('solicitud_id')->unsigned()->nullable();
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
        Schema::dropIfExists('movimiento_almacenes');
    }
}
