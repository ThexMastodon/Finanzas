<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Estatus;

class EstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Estatus::updateOrCreate(
          ['descripcion' => 'Cancelado'],
          ['descripcion' => 'Cancelado']
        );

        Estatus::updateOrCreate(
          ['descripcion' => 'Activo'],
          ['descripcion' => 'Activo']
        );
    }
}
