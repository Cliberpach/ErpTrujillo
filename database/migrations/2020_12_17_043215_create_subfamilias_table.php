<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubfamiliasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subfamilias', function (Blueprint $table) {
            
            $table->engine = 'InnoDB';
            $table->Increments('id');
            $table->string('descripcion');
            $table->unsignedInteger('familia_id')->unsigned();
            $table->foreign('familia_id')
                  ->references('id')->on('familias')
                  ->onDelete('cascade');
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
        Schema::dropIfExists('subfamilias');
    }
}
