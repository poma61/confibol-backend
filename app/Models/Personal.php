<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Personal extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombres',
        'apellido_paterno',
        'apellido_materno',
        'cargo',
        'ci',
        'ci_expedido',
        'n_de_contacto',
        'correo_electronico',
        'direccion',
        'foto_image_path',
        'status',
        'id_desarrolladora',
    ];
    
    protected $hidden = [
        'updated_at',
        'status',
        'created_at',
    ];
    
}
