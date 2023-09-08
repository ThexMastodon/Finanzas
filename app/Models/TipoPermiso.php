<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TipoPermiso extends Model
{
  protected $table = 'tipo_permiso';

  protected $fillable = [
    'id_s',
    'nombre',
  ];
}
