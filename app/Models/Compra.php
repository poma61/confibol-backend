<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nota',
        'fecha_compra',
        'status',
        'id_ciudad',
      ];
  
      protected $hidden = [
          'updated_at',
          'status',
          'created_at',
      ];

}
