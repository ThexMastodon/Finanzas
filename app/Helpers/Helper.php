<?php

namespace App\Helpers;

use App\Models\Modulo;
use App\Models\Submodulo;
use Illuminate\Support\Facades\Log;

class Helper
{
  public static function obtenerNombrePermiso($nombre, $tipoPermisoId, $modsub)
  {
    $modulosub = $modsub === 'M' ? Modulo::where('nombre', $nombre)->first() : Submodulo::where('nombre', $nombre)->first();

    if ($modulosub) {
      return  $modulosub->permisos()
        ->whereHas('tipoPermiso', function ($query) use ($tipoPermisoId) {
          $query->where('id_s', $tipoPermisoId);
        })
        ->value('name') ?? false;
    }
    return false;
  }
}


