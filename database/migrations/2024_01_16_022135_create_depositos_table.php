<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('depositos', function (Blueprint $table) {
            $table->id();
            $table->string('nombres');
            $table->string('direccion');
            $table->foreignId('id_ciudad');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('id_ciudad')->references('id')->on('ciudades');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('depositos');
    }
};
