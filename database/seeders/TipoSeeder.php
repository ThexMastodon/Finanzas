<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tipo;

class TipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Tipo::updateOrCreate(
          ['descripcion' => 'Fianza'],
          ['descripcion' => 'Fianza']
        );

        Tipo::updateOrCreate(
          ['descripcion' => 'Cheque'],
          ['descripcion' => 'Cheque']
        );

        Tipo::updateOrCreate(
          ['descripcion' => 'Pagaré'],
          ['descripcion' => 'Pagaré']
        );

        Tipo::updateOrCreate(
          ['descripcion' => 'Billete de Depósito'],
          ['descripcion' => 'Billete de Depósito']
        );
    }
}
