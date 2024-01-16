<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
 
    public function up(): void
    {
        Schema::create('clientes', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('nombres');
            $table->string('apellido_paterno');
            $table->string('apellido_materno');
            $table->string('n_de_contacto', 100); //string ya que los numeros telefonicos suelen ser grandes cifras
            $table->string('correo_electronico')->nullable();
            $table->string('ci', 100);
            $table->string('ci_expedido', 10);
            $table->text('direccion');
            $table->longText('descripcion')->nullable();
            $table->foreignId('id_grupo');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('id_grupo')->references('id')->on('grupos');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
