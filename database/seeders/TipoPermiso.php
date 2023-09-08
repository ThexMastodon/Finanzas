<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TipoPermiso extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $data = [
        [
          'nombre' => 'Agregar',
          'id_s' => 'A',
        ],
        [
          'nombre' => 'Editar',
          'id_s' => 'E',
        ],
        [
          'nombre' => 'Eliminar',
          'id_s' => 'D',
        ],
        [
          'nombre' => 'Consultar',
          'id_s' => 'C',
        ],
      ];

      foreach ($data as $tipoPermiso) {
        \App\Models\TipoPermiso::create($tipoPermiso);
      }
    }
}
