<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Afianzadora;

class AfianzadorasSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Afianzadora::updateOrCreate(['nombre' => 'BANCO INBURSA, S.A. DE C.V.'], ['id' => 9, 'nombre' => 'BANCO INBURSA, S.A. DE C.V.']);
    Afianzadora::updateOrCreate(['nombre' => 'MONTERREY Y AETNA S.A.'], ['id' => 1, 'nombre' => 'MONTERREY Y AETNA S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'ATLAS S.A.'], ['id' => 2, 'nombre' => 'ATLAS S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BITAL S.A.'], ['id' => 3, 'nombre' => 'BITAL S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'INSURGENTES S.A.'], ['id' => 4, 'nombre' => 'INSURGENTES S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'LOTONAL S.A.'], ['id' => 5, 'nombre' => 'LOTONAL S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BANORTE S.A.'], ['id' => 6, 'nombre' => 'BANORTE S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'SOFIMEX S.A.'], ['id' => 7, 'nombre' => 'SOFIMEX S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BBV* PROBURSA S.A. DE C.V.'], ['id' => 8, 'nombre' => 'BBV* PROBURSA S.A. DE C.V.']);
    Afianzadora::updateOrCreate(['nombre' => 'INVERMEXICO'], ['id' => 11, 'nombre' => 'INVERMEXICO']);
    Afianzadora::updateOrCreate(['nombre' => 'CHUBB DE MEXICO S.A.'], ['id' => 12, 'nombre' => 'CHUBB DE MEXICO S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'COMERCIAL AMERICANA'], ['id' => 13, 'nombre' => 'COMERCIAL AMERICANA']);
    Afianzadora::updateOrCreate(['nombre' => 'ASECAM S.A.'], ['id' => 14, 'nombre' => 'ASECAM S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BBVA BANCOMER S.A.'], ['id' => 16, 'nombre' => 'BBVA BANCOMER S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BANAMEX S.A.'], ['id' => 17, 'nombre' => 'BANAMEX S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'GRUPO FINANCIERO SERFIN S.A.'], ['id' => 19, 'nombre' => 'GRUPO FINANCIERO SERFIN S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BBV BANCO BILBAO VIZCAYA S.A.'], ['id' => 20, 'nombre' => 'BBV BANCO BILBAO VIZCAYA S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'SCOTIABANK INVERLAT S.A.'], ['id' => 21, 'nombre' => 'SCOTIABANK INVERLAT S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BANCA AFIRME S.A.'], ['id' => 23, 'nombre' => 'BANCA AFIRME S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BANCRECER S.A.'], ['id' => 24, 'nombre' => 'BANCRECER S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BANCO INDUSTRIAL, S.A.'], ['id' => 30, 'nombre' => 'BANCO INDUSTRIAL, S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'INSTITUTO DE BANCA DE DESARROLLO BANRURAL'], ['id' => 32, 'nombre' => 'INSTITUTO DE BANCA DE DESARROLLO BANRURAL']);
    Afianzadora::updateOrCreate(['nombre' => 'BANCO SANTANDER MEXICANO'], ['id' => 33, 'nombre' => 'BANCO SANTANDER MEXICANO']);
    Afianzadora::updateOrCreate(['nombre' => 'GUARDIANA INBURSA,S.A.'], ['id' => 34, 'nombre' => 'GUARDIANA INBURSA,S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'BANSEFI'], ['id' => 35, 'nombre' => 'BANSEFI']);
    Afianzadora::updateOrCreate(['nombre' => 'BANCOMER'], ['id' => 36, 'nombre' => 'BANCOMER']);
    Afianzadora::updateOrCreate(['nombre' => 'GRUPO FINANCIERO SANTANDER SERFIN'], ['id' => 37, 'nombre' => 'GRUPO FINANCIERO SANTANDER SERFIN']);
    Afianzadora::updateOrCreate(['nombre' => 'SANTANDER SERFIN'], ['id' => 40, 'nombre' => 'SANTANDER SERFIN']);
    Afianzadora::updateOrCreate(['nombre' => 'BANCO DEL BAJIO'], ['id' => 41, 'nombre' => 'BANCO DEL BAJIO']);
    Afianzadora::updateOrCreate(['nombre' => 'HSBC'], ['id' => 43, 'nombre' => 'HSBC']);
    Afianzadora::updateOrCreate(['nombre' => 'SANTANDER MEXICANO'], ['id' => 44, 'nombre' => 'SANTANDER MEXICANO']);
    Afianzadora::updateOrCreate(['nombre' => 'IXE BANCO, S.A.'], ['id' => 45, 'nombre' => 'IXE BANCO, S.A.']);
    Afianzadora::updateOrCreate(['nombre' => 'ASERTA'], ['id' => 46, 'nombre' => 'ASERTA']);
    Afianzadora::updateOrCreate(['nombre' => 'BANREGIO'], ['id' => 47, 'nombre' => 'BANREGIO']);
    Afianzadora::updateOrCreate(['nombre' => 'SANTANDER'], ['id' => 48, 'nombre' => 'SANTANDER']);
    Afianzadora::updateOrCreate(['nombre' => 'PRIMERO S.A. DE C.V.'], ['id' => 49, 'nombre' => 'PRIMERO S.A. DE C.V.']);
  }
}
