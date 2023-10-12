<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiEstado extends Model
{
  protected $table = 'catalogo_estados_api';

  use HasFactory;

  protected $fillable = [
    'id',
    'estado_id',
    'clave',
    'descripcion'
  ];
}
