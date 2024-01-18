<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentoCompra extends Model
{
    use HasFactory;
    protected $table = "documentos_compras";

    protected $fillable = [
        'tipo_compra',
        'recibo',
        'factura',
        'lista_empaque',
        'poliza',
        'factura_importacion',
        'id_compra',
        'status',
    ];

    protected $hidden = [
        'updated_at',
        'status',
        'created_at',
    ];
}//
