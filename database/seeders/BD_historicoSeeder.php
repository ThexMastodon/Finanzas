<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\FianzasChequesImport;
use App\Imports\CanceladosImport;

class BD_historicoSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    $excelFile = base_path('BD_SDFC.xlsx');
    $excelFileCancelado = base_path('CANCELADOS_BD.xlsx');

    // Hoja 1: Fianzas Cheques
    Excel::import(new FianzasChequesImport(), $excelFile);

    // Hoja 2: Cancelados
    Excel::import(new CanceladosImport(), $excelFileCancelado);
  }
}
