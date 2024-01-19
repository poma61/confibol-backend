<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('lote_productos', function (Blueprint $table) {
            $table->engine = 'InnoDB ROW_FORMAT=DYNAMIC';
            $table->id();
            $table->string('codigo');
            $table->string('fecha_vencimiento');
            $table->longText('descripcion')->nullable();
            $table->double('costo_unitario', 40, 2);
            $table->bigInteger('cantidad');
            $table->double("peso_neto", 40, 2);
            $table->string("unidad_medida_peso_neto", 50);
            $table->foreignId('id_producto');
            $table->foreignId('id_compra');
            $table->foreignId('id_deposito');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('id_producto')->references('id')->on('productos');
            $table->foreign('id_compra')->references('id')->on('compras');
            $table->foreign('id_deposito')->references('id')->on('depositos');
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('lote_productos');
    }
};
