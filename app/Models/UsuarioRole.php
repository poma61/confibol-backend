<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioRole extends Model
{
    use HasFactory;
    protected $table = "usuarios_has_roles";

    protected $hidden = [
        'status',
        'updated_at',
        'created_at',
    ];

} //class
