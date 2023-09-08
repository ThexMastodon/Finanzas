<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Municipio extends Model
{
  protected $fillable = [
    'nombre',
    'activo',
    'estado_id'
  ];
    use HasFactory;

    protected $table = 'municipios';

    public function colonia() {
      return $this->hasMany(Colonia::class, 'municipio_id');
    }

    public function direccion() {
      return $this->hasMany(Direccion::class, 'municipio_id');
    }
}
