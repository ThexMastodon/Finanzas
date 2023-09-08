<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Fianza_cheque extends Model
{
  use HasApiTokens, HasFactory, Notifiable, HasRoles;

  protected $fillable = [
    'id',
    'no_fianza_cheque',
    'nombre',
    'apellido_paterno',
    'apellido_materno',
    'tipo_persona',
    'fecha_expedicion',
    'fecha_vencimiento',
    'fecha_captura',
    'expedido_por',
    'a_favor',
    'importe',
    'licitación',
    'concepto',
    'direccion_historico',
    'oficio',
    'fecha_oficio',
    'afianzadoras_id',
    'tipo_id',
    'estatus_id',
    'direccion_id',
  ];

  public function afianzadoras()
  {
    return $this->belongsTo(Afianzadora::class, 'afianzadoras_id', 'id');
  }

  public function estatus()
  {
    return $this->hasOne(Estatus::class, 'id', 'estatus_id');
  }

  public function tipo()
  {
    return $this->hasOne(Tipo::class, 'id', 'tipo_id');
  }

  public function cancelados()
  {
    return $this->hasOne(Cancelado::class, 'fianza_cheque_id', 'id');
  }

  public function direccion()
  {
    return $this->hasOne(Direccion::class, 'id', 'direccion_id');
  }
}
