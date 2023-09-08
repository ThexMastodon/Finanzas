<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Cancelado extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  protected $fillable = [
    'id',
    'fecha_cancelacion',
    'oficio',
    'fecha_oficio',
    'users_id',
    'afianzadoras_id',
    'fianza_cheque_id',
  ];

  public function afianzadora()
  {
    return $this->belongsTo(Afianzadora::class, 'afianzadoras_id');
  }

  public function fianza_cheque()
  {
    return $this->belongsTo(Fianza_cheque::class, 'fianza_cheque_id');
  }

  public function user()
  {
    return $this->belongsTo(User::class, 'users_id');
  }
}
