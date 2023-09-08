<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estado extends Model
{   protected $fillable = [
  'nombre',
  'activo',
];
    use HasFactory;

    protected $table = 'estados';

    public function municipio() {
      return $this->hasMany(Municipio::class, 'municipio_id');
    }

    public function colonia() {
      return $this->hasMany(Colonia::class, 'colonia_id');
    }

    public function direccion() {
      return $this->hasMany(Direccion::class, 'direccion_id');
    }

}
