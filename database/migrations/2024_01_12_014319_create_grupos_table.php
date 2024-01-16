<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('grupos', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('number', 5);
            $table->string('descripcion');
            $table->foreignId('id_ciudad');
            $table->timestamps();

            $table->foreign('id_ciudad')->references('id')->on('ciudades');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
