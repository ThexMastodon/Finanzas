<?php

namespace Database\Seeders;

use App\Models\Colonia;
use App\Models\Estado;
use App\Models\Municipio;
use Illuminate\Database\Seeder;

use PhpOffice\PhpSpreadsheet\IOFactory;

class ColoniasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

  function leerArchivoExcel($rutaArchivo)
  {
    $spreadsheet = IOFactory::load($rutaArchivo);
    $worksheet = $spreadsheet->getActiveSheet();
    $data = $worksheet->toArray(null, true, true, true);

    $arregloAsociativo = [];
    $columnas = array_shift($data);

    foreach ($data as $row) {
      $registro = [];
      foreach ($columnas as $columna => $nombreColumna) {
        $registro[$nombreColumna] = $row[$columna];
      }
      $arregloAsociativo[] = $registro;
    }

    return $arregloAsociativo;
  }

    public function run(): void
    {
      $arr_direcciones = $this->leerArchivoExcel('direcciones.xls');

      $estado = Estado::where('nombre', 'Michoacán de Ocampo')->first();

      foreach ($arr_direcciones as $direccion) {
        if (!empty(array_filter($direccion))) {

          $municipio = Municipio::where('nombre', $direccion['D_mnpio'])->first();

          Colonia::updateOrCreate(
            [
              'colonia' => $direccion['d_asenta'],
              'codigo_postal' => $direccion['d_codigo'],
              'municipio_id' => $municipio->id
            ],
            [
              'estado_id' => $estado->id
            ]
          );
        }
      }
    }
}
