<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('productos', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('nombre_producto');
            $table->string('marca');
            $table->string('image_path');
            $table->string('categoria');
            $table->boolean('status');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
