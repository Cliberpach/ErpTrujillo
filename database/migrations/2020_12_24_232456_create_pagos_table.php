<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePagosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pagos', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('orden_id')->unsigned();
            $table->foreign('orden_id')
                  ->references('id')->on('ordenes')
                  ->onDelete('cascade');

            $table->BigInteger('id_banco_proveedor');
            $table->BigInteger('id_banco_empresa');
            
            $table->date('fecha_pago');
            $table->unsignedDecimal('monto', 15,2);

            $table->string('moneda_empresa');
            $table->string('moneda_proveedor');
            $table->string('moneda');
            
            $table->unsignedDecimal('tipo_cambio', 15,2)->nullable();
            $table->unsignedDecimal('cambio', 15,2)->nullable();

            $table->string('ruta_archivo')->nullable();
            $table->string('nombre_archivo')->nullable();
            $table->mediumText('observacion')->nullable();

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
        Schema::dropIfExists('pagos');
    }
}
