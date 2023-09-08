<?php

namespace App\Imports;

use App\Models\Fianza_cheque;
use Maatwebsite\Excel\Concerns\ToModel;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\Afianzadora;

class FianzasChequesImport implements ToModel, WithStartRow
{
  public function model(array $row)
  {
    $afianzadoraId = $row[9]; // Obtén el valor de 'afianzadoras_id'

    // Verificar si la afianzadora existe
    $afianzadora = Afianzadora::find($afianzadoraId);

    if (!$afianzadora) {
      // La afianzadora no existe, puedes omitir este registro o hacer algo más
      $afianzadoraId = null;
    }
    return new Fianza_cheque([
      'id' => $row[0],
      'no_fianza_cheque' => $row[1],
      'tipo_id' => $row[2],
      'fecha_expedicion' => Date::excelToDateTimeObject($row[3]),
      'fecha_vencimiento' => Date::excelToDateTimeObject($row[4]),
      'fecha_captura' => Date::excelToDateTimeObject($row[5]),
      'expedido_por' => $row[6],
      'direccion_historico' => $row[7],
      'a_favor' => $row[8],
      'afianzadoras_id' => $afianzadora->id ?? $afianzadoraId,
      'importe' => $row[10],
      'licitación' => $row[11],
      'concepto' => $row[12],
      'estatus_id' => 2,
    ]);
  }

  public function startRow(): int
  {
    return 2; // Omitir la primera fila (encabezados)
  }
}
