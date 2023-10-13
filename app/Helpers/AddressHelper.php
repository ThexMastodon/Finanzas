<?php

namespace App\Helpers;

use App\Models\Colonia;
use GuzzleHttp\Psr7\HttpFactory;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Models\ApiColonia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

  public static function searchColonias($codigo_postal)
  {
    $apipi = Request::create('/api/colonias/'.$codigo_postal, 'GET');

    $cp = Route::dispatch($apipi)->getContent();

    $data = json_decode($cp, true);

    $colonias = $data['colonia'];

    $direcciones = [];

    foreach ($colonias as $colonia) {
      $direccion = [
        'colonia' => $colonia['descripcion'],
        'colonia_id' => $colonia['id'],
        'municipio' => $colonia['municipio'],
        'municipio_id' => $colonia['municipio_id'],
        'estado' => $colonia['estado'],
        'estado_id' => $colonia['estado_id'],
      ];

      $direcciones[] = $direccion;
    }

    return $direcciones;

  }
}
