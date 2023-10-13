<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Direccion extends Model
{
    protected $table = 'direcciones';

    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'id',
        'municipio_id',
        'estado_id',
        'colonia_id',
        'calle',
        'codigo_postal',
        'no_interior',
        'no_exterior',
        'referencia',
    ];

    public function afianzadora(){
      return $this->belongsTo(Afianzadora::class, 'direccion_id', 'id');
    }

    public function estado(){
      return $this->belongsTo(ApiEstado::class, 'estado_id', 'id');
    }

    public function municipio(){
      return $this->belongsTo(ApiMunicipio::class, 'municipio_id', 'id');
    }

    public function colonia(){
      return $this->belongsTo(ApiColonia::class, 'colonia_id', 'id');
    }

    public function fianza_cheque(){
      return $this->belongsTo(Fianza_cheque::class, 'direccion_id', 'id');
    }
}
