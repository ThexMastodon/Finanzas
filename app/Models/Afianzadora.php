<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Afianzadora extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'nombre',
        'activo',
        'direccion_id',
    ];

    public function fianza_cheques(){
      return $this->hasMany(Fianza_cheque::class, 'id', 'afianzadoras_id');
    }

    public function direccion(){
      return $this->hasOne(Direccion::class, 'id', 'direccion_id');
    }

    public function cancelados(){
      return $this->hasMany(Cancelado::class, 'id', 'afianzadoras_id');
    }
}
