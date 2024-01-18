<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductoLote extends Model
{
    use HasFactory;

    protected $hidden = [
        'updated_at',
        'status',
        'created_at',
    ];
    
}
