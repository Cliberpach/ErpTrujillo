<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDetallePrototiposTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_prototipos', function (Blueprint $table) {
            $table->Increments('id');
            $table->unsignedInteger('prototipo_id')->unsigned();
            $table->foreign('prototipo_id')
                  ->references('id')->on('prototipos')
                  ->onDelete('cascade');
            $table->string('nombre_articulo');
            $table->unsignedDecimal('cantidad',15,2)->nullable();
            $table->mediumText('observacion')->nullable();
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
        Schema::dropIfExists('detalle_prototipos');
    }
}
