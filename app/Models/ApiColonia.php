<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiColonia extends Model
{
  protected $table = 'catalogo_colonias_api';

  use HasFactory;

  protected $fillable = [
    'id',
    'municipio_id',
    'clave',
    'descripcion',
    'codigo_postal'
  ];
}
