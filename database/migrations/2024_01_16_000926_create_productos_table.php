<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->boolean('status');
            $table->foreignId('id_categoria');
            $table->timestamps();

            $table->foreign('id_categoria')->references('id')->on('categorias');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
