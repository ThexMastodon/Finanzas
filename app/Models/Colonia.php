<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Colonia extends Model
{
    use HasFactory;

    protected $table = 'colonias';

    protected $fillable = [
      'codigo_postal',
      'colonia',
      'estado_id',
      'municipio_id',
      'activo'
    ];

    public function municipio()
    {
      return $this->belongsTo(Municipio::class, 'municipio_id');
    }

    public function estado()
    {
      return $this->belongsTo(Estado::class, 'estado_id');
    }

    public function direcciones()
    {
      return $this->belongsTo(Direccion::class, 'colonia_id');
    }

}
