<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;

class ModuloSubmoduloPermissions extends Model
{
  protected $table = 'modulo_submodulo_permissions';

  protected $fillable = [
    'modulo_id',
    'submodulo_id',
    'permission_id',
  ];

  // Relación con el módulo asociado
  public function modulo()
  {
    return $this->belongsTo(Modulo::class, 'modulo_id');
  }

  // Relación con el submódulo asociado
  public function submodulo()
  {
    return $this->belongsTo(Submodulo::class, 'submodulo_id');
  }

  // Relación con el permiso asociado
  public function permission()
  {
    return $this->belongsTo(PermissionCustom::class, 'permission_id');
  }
}
