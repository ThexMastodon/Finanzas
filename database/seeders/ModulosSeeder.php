<?php

namespace Database\Seeders;

use App\Models\Modulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      Modulo::updateOrCreate(['nombre' => 'Configuraciones','icono'=>'fas fa-fw fa-cog'],['status'=> 1]);
      Modulo::updateOrCreate(['nombre' => 'Catalogos','icono'=>'fas fa-fw fa-book'],['status'=> 1]);
      Modulo::updateOrCreate(['nombre' => 'Operaciones','icono'=>'fas fa-fw fa-briefcase'],['status'=> 1]);

    }
}
