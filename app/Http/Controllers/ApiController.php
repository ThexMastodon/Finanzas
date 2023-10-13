<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ApiEstado;
use App\Models\ApiMunicipio;
use App\Models\ApiColonia;
use Illuminate\Support\Facades\Log;

class ApiController extends Controller
{
  public function estado()
  {
    try {
      $estados = ApiEstado::select('id', 'estado_id', 'clave', 'descripcion')
        ->orderBy('id', 'asc')
        ->get();

        return response()->json([
        'status' => 'success',
        'estado' => $estados,
      ], 200);
    } catch (\Exception $e) {
      Log::error("ApiController@estado. Error: {$e->getMessage()}");

      return response()->json([
        'message' => 'Ocurrió un error al realizar la operación.'
      ]);
    }
  }

  public function municipio(Request $request, $id)
  {
    try {
      $municipios = ApiMunicipio::select('catalogo_municipios_api.id', 'catalogo_municipios_api.estado_id', 'catalogo_municipios_api.clave', 'catalogo_municipios_api.descripcion', 'catalogo_estados_api.descripcion as estado')
        ->leftJoin('catalogo_estados_api', 'catalogo_municipios_api.estado_id', '=', 'catalogo_estados_api.id')
        ->where('catalogo_municipios_api.estado_id', $id)
        ->orderBy('catalogo_municipios_api.id', 'asc')
        ->get();

        return response()->json([
        'status' => 'success',
        'municipio' => $municipios,
      ], 200);
    } catch (\Exception $e) {
      Log::error("ApiController@municipio. Error: {$e->getMessage()}");

      return response()->json([
        'message' => 'Ocurrió un error al realizar la operación.'
      ]);
    }
  }

  public function colonia(Request $request, $codigo_postal)
  {
    try {
      $colonia = ApiColonia::select('catalogo_colonias_api.id', 'catalogo_colonias_api.municipio_id', 'catalogo_colonias_api.codigo_postal', 'catalogo_colonias_api.descripcion', 'catalogo_municipios_api.descripcion as municipio', 'catalogo_estados_api.descripcion as estado', 'catalogo_estados_api.id as estado_id')
        ->leftJoin('catalogo_municipios_api', 'catalogo_colonias_api.municipio_id', '=', 'catalogo_municipios_api.id')
        ->leftJoin('catalogo_estados_api', 'catalogo_municipios_api.estado_id', '=', 'catalogo_estados_api.id')
        ->where('catalogo_colonias_api.codigo_postal', $codigo_postal)
        ->orderBy('id', 'asc')
        ->get();

        return response()->json([
        'status' => 'success',
        'colonia' => $colonia,
      ], 200);
    } catch (\Exception $e) {
      Log::error("ApiController@colonia. Error: {$e->getMessage()}");

      return response()->json([
        'message' => 'Ocurrió un error al realizar la operación.'
      ]);
    }
  }
}
