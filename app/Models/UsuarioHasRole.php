<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UsuarioHasRole extends Model
{
    use HasFactory;

    protected $table = "usuarios_has_roles";

    protected $fillable = [
        'id_user',
        'id_role',
        'status',
    ];

    protected $hidden = [
        'status',
        'updated_at',
        'created_at',
    ];

} //class
