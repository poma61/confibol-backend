<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('documentos_compras', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('tipo_compra', 100);
            $table->string('recibo')->nullable();
            $table->string('factura_nacional')->nullable();
            $table->string('lista_empaque')->nullable();
            $table->string('poliza')->nullable();
            $table->string('factura_importacion')->nullable();
            $table->foreignId('id_compra');
            $table->boolean('status');
            $table->timestamps();
            $table->foreign('id_compra')->references('id')->on('compras');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('documentos_compras');
    }
};
