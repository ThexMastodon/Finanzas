<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiMunicipio extends Model
{
  protected $table = 'catalogo_municipios_api';

  use HasFactory;

  protected $fillable = [
    'id',
    'estado_id',
    'clave',
    'descripcion'
  ];

  public function estado()
{
    return $this->belongsTo(ApiEstado::class, 'estado_id');
}
}
