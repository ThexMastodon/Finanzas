<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\ApiColonia;
use App\Models\Direccion;

class CambioColoniasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $direcciones = Direccion::select('direcciones.id', 'municipios.nombre as municipio', 'colonias.colonia', 'colonias.codigo_postal')
        ->leftJoin('municipios', 'direcciones.municipio_id', '=', 'municipios.id')
        ->leftJoin('colonias', 'direcciones.colonia_id', '=', 'colonias.id')
        ->get();

      foreach ($direcciones as $direccion){
        if(!$direccion->colonia == null && !$direccion->codigo_postal == null){

          $nuevaDir = ApiColonia::select('catalogo_colonias_api.id as colonia_id', 'catalogo_colonias_api.descripcion as colonia', 'catalogo_municipios_api.id as municipio_id', 'catalogo_municipios_api.descripcion as municipio', 'catalogo_estados_api.id as estado_id', 'catalogo_estados_api.descripcion as estado')
            ->where('catalogo_colonias_api.descripcion', '=', $direccion->colonia)
            ->where('catalogo_colonias_api.codigo_postal', '=', $direccion->codigo_postal)
            ->leftJoin('catalogo_municipios_api', 'catalogo_colonias_api.municipio_id', '=', 'catalogo_municipios_api.id')
            ->leftJoin('catalogo_estados_api', 'catalogo_municipios_api.estado_id', '=', 'catalogo_estados_api.id')
            ->first();

          Direccion::where('direcciones.id', $direccion->id)
            ->update([
              'colonia_id' => $nuevaDir->colonia_id,
              'municipio_id' => $nuevaDir->municipio_id,
              'estado_id' => $nuevaDir->estado_id
            ]);
        }

      }
    }
}
