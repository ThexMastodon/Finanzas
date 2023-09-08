<?php

namespace App\Models;

use App\Models\Submodulo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Modulo extends Model
{
  protected $fillable = [
    'id',
    'nombre',
    'status',

  ];
  protected $table = 'modulos';

  public function submodulos()
  {
    return $this->hasMany(Submodulo::class, 'modulo_id');
  }

  public function permisos()
  {
    return $this->belongsToMany(PermissionCustom::class, 'modulo_submodulo_permissions', 'modulo_id', 'permission_id')
      ->whereNull('submodulo_id');
  }

  use HasFactory;
}
