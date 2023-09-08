<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;


class Estatus extends Authenticatable
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  protected $table = 'estatus';
  protected $fillable = [
    'descripcion',
    'activo',
  ];

  public function afianzadoras()
  {
    return $this->belongsTo(Afianzadora::class, 'afianzadoras_id', 'id');
  }
}
