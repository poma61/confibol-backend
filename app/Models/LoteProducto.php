<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        "uuid",
        "codigo",
        "fecha_vencimiento",
        "descripcion",
        "costo_unitario",
        "cantidad",
        "peso_neto",
        "unidad_medida_peso_neto",
        "id_producto",
        "id_compra",
        "id_deposito",
        "status",
    ];
    protected $hidden = [
        'updated_at',
        'status',
        'created_at',
    ];

}
