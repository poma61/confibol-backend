<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoteProducto extends Model
{
    use HasFactory;

    protected $fillable = [
        "fecha_vecimiento",
        "detalle",
        "cantidad",
        "costo_unitario",
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
