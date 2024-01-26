<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre_producto',
        'marca',
        'image_path',
        'categoria',
        'status',
    ];

    protected $hidden = [
        'updated_at',
        'status',
        'created_at',
    ];

}
