<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticulosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articulos', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('descripcion');
            $table->string('codigo_fabrica');
            $table->BigInteger('stock')->nullable();
            $table->BigInteger('stock_min');
            $table->unsignedDecimal('precio_compra', 15,2);
            $table->string('presentacion');
            
            $table->unsignedInteger('categoria_id')->unsigned();
            $table->foreign('categoria_id')
                  ->references('id')->on('categorias')
                  ->onDelete('cascade');

            $table->unsignedInteger('almacen_id')->unsigned();
            $table->foreign('almacen_id')
                ->references('id')->on('almacenes')
                ->onDelete('cascade');
            
            $table->string('unidad_medida');

            $table->string('codigo_barra')->nullable();
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
        Schema::dropIfExists('articulos');
    }
}
