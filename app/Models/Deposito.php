<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Deposito extends Model
{
    use HasFactory;

    protected $fillable = [
      'nombres',
      'direccion',
      'id_ciudad',
      'status',
    ];

    protected $hidden = [
      'updated_at',
      'status',
      'created_at',
  ];
    
}//class
