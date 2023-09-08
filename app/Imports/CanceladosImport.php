<?php

// CanceladosImport.php
namespace App\Imports;

use App\Models\Cancelado;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\Afianzadora;
use App\Models\Fianza_cheque;

class CanceladosImport implements ToModel, WithStartRow
{
  public function model(array $row)
  {
    $afianzadoraId = $row[10]; // Obtén el valor de 'afianzadoras_id'
    // Verificar si la afianzadora existe
    $afianzadora = Afianzadora::find($afianzadoraId);
    if (!$afianzadora) {
      // La afianzadora no existe, puedes omitir este registro o hacer algo más
      $afianzadora = null;
    }else{
      $afianzadora = $afianzadora->id;
    }
    $fianzaChequeId = $row[1];
    // Verificar si la fianza cheque existe
    $fianzaCheque = Fianza_cheque::where('no_fianza_cheque', $fianzaChequeId)->first();
    if (!$fianzaCheque) {
      // La fianza cheque no existe, puedes omitir este registro o hacer algo más
      $fianzaChequeId = null;
    }else{
      $fianzaCheque->estatus_id = 1;
      $fianzaCheque->save();
    }
    return new Cancelado([
      'id' => $row[0],
      'fecha_cancelacion' => Date::excelToDateTimeObject($row[6]),
      'afianzadoras_id' => $afianzadora,
      'oficio' => $row[14],
      'fecha_oficio' => Date::excelToDateTimeObject($row[15]),
      'fianza_cheque_id' => $fianzaCheque->id ?? $fianzaChequeId,
    ]);
  }

  public function startRow(): int
  {
    return 2; // Omitir la primera fila (encabezados)
  }
}
