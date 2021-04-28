<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClienteTiendasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cliente_tiendas', function (Blueprint $table) {
            $table->Increments('id');
            $table->string('nombre');
            $table->unsignedInteger('cliente_id');
            $table->foreign('cliente_id')->references('id')->on('clientes')->onDelete('cascade');
            $table->string('tipo_tienda');
            $table->string('tipo_negocio');
            $table->mediumText('direccion')->nullable();
            $table->string('ubigeo')->nullable();

            $table->string('facebook')->nullable();
            $table->string('web')->nullable();            
            $table->string('instagram')->nullable();

            $table->string('correo')->nullable();
            $table->string('telefono')->nullable();
            $table->string('celular')->nullable();

            // $table->string('dias');
            $table->string('hora_inicio')->nullable();
            $table->string('hora_fin')->nullable();
            
            

            //CONTACTO ADMINISTRADOR
            $table->string('dni_contacto_admin')->nullable();
            $table->string('estado_dni_contacto_admin')->default('SIN VERIFICAR');

            $table->string('contacto_admin_nombre')->nullable();
            $table->string('contacto_admin_cargo')->nullable();
            $table->date('contacto_admin_fecha_nacimiento')->nullable();
            $table->string('contacto_admin_correo')->nullable();
            $table->string('contacto_admin_celular')->nullable();
            $table->string('contacto_admin_telefono')->nullable();

            //CONTACTO CREDITO

            $table->string('dni_contacto_credito')->nullable();
            $table->string('estado_dni_contacto_credito')->default('SIN VERIFICAR');

            $table->string('contacto_credito_nombre')->nullable();
            $table->string('contacto_credito_cargo')->nullable();
            $table->date('contacto_credito_fecha_nacimiento')->nullable();
            $table->string('contacto_credito_correo')->nullable();
            $table->string('contacto_credito_celular')->nullable();
            $table->string('contacto_credito_telefono')->nullable();

            //CONTACTO VENDEDOR
            $table->string('dni_contacto_vendedor')->nullable();
            $table->string('estado_dni_contacto_vendedor')->default('SIN VERIFICAR');

            $table->string('contacto_vendedor_nombre')->nullable();
            $table->string('contacto_vendedor_cargo')->nullable();
            $table->date('contacto_vendedor_fecha_nacimiento')->nullable();
            $table->string('contacto_vendedor_correo')->nullable();
            $table->string('contacto_vendedor_celular')->nullable();
            $table->string('contacto_vendedor_telefono')->nullable();


            ///////////////////////////////////////////////////////////////////

            $table->string('condicion_reparto')->nullable();

            $table->string('ruc_transporte_oficina')->nullable();
            $table->string('estado_transporte_oficina')->default('SIN VERIFICAR');
            $table->string('nombre_transporte_oficina')->nullable();
            $table->string('direccion_transporte_oficina')->nullable();
            
            $table->string('responsable_pago_flete')->nullable();
            $table->string('responsable_pago')->nullable();

            $table->string('dni_responsable_recoger')->nullable();
            $table->string('estado_responsable_recoger')->nullable();
            $table->string('nombre_responsable_recoger')->nullable();
            $table->string('telefono_responsable_recoger')->nullable();
            $table->string('observacion_envio')->nullable();


            $table->string('ruc_transporte_domicilio')->nullable();
            $table->string('estado_transporte_domicilio')->default('SIN VERIFICAR');
            $table->string('nombre_transporte_domicilio')->nullable();
            $table->string('direccion_domicilio')->nullable();

            $table->string('dni_contacto_recoger')->nullable();
            $table->string('estado_dni_contacto_recoger')->default('SIN VERIFICAR');
            $table->string('nombre_contacto_recoger')->nullable();
            $table->string('telefono_contacto_recoger')->nullable();
            $table->string('observacion_domicilio')->nullable();


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
        Schema::dropIfExists('cliente_tiendas');
    }
}
