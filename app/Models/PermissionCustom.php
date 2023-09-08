<?php

namespace App\Models;

use Spatie\Permission\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class PermissionCustom extends Permission
{
  public function tipoPermiso()
  {
    return $this->belongsTo(TipoPermiso::class, 'tipo_permiso_id');
  }
}
