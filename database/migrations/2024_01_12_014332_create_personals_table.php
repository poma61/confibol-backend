<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('personals', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('nombres', 200);
            $table->string('apellido_paterno', 200);
            $table->string('apellido_materno', 200);
            $table->string('cargo', 250);
            $table->string('ci', 100);
            $table->string('ci_expedido', 10);
            $table->string('n_de_contacto', 100)->nullable();
            $table->string('correo_electronico', 100)->nullable();
            $table->text('direccion')->nullable();
            $table->string('foto');
            $table->boolean('status');
            $table->foreignId('id_ciudad');
            $table->timestamps();
            $table->foreign('id_ciudad')->references('id')->on('ciudades');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personals');
    }
};
