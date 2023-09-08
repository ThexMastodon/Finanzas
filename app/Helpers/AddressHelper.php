<?php

namespace App\Helpers;

use App\Models\Colonia;
use Illuminate\Support\Facades\Log;

class AddressHelper
{
  public static function searchCP($codigo_postal)
  {
    $colonias = Colonia::where('codigo_postal', $codigo_postal)->with('municipio', 'estado')->get();

    if ($colonias->isNotEmpty()) {
      $direcciones = [];

      foreach ($colonias as $colonia) {
        $direccion = [
          'colonia' => $colonia->colonia,
          'colonia_id' => $colonia->id,
          'municipio' => $colonia->municipio->nombre,
          'municipio_id' => $colonia->municipio->id,
          'estado' => $colonia->estado->nombre,
          'estado_id' => $colonia->estado->id,
        ];

        $direcciones[] = $direccion;
      }

      return $direcciones;
    }

    return null;
  }
}
