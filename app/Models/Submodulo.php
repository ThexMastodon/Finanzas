<?php

namespace App\Models;

use App\Models\Modulo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Submodulo extends Model
{
  protected $fillable = [
    'nombre',
    'status',
    'modulo_id'
  ];

  protected $table = 'submodulos';
  use HasFactory;

  public function modulo()
  {
    return $this->belongsTo(Modulo::class, 'id');
  }

  public function moduloSubmoduloPermissions()
  {
    return $this->hasMany(ModuloSubmoduloPermissions::class);
  }

  public function permisos()
  {
    return $this->hasManyThrough(PermissionCustom::class, ModuloSubmoduloPermissions::class, 'submodulo_id', 'id', 'id', 'permission_id');
  }
}
