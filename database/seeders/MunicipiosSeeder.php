<?php

namespace Database\Seeders;

use App\Models\Estado;
use App\Models\Municipio;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MunicipiosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $arr_municipios = [
        'Acuitzio',
        'Aguililla',
        'Álvaro Obregón',
        'Angamacutiro',
        'Angangueo',
        'Apatzingán',
        'Aporo',
        'Aquila',
        'Ario',
        'Arteaga',
        'Briseñas',
        'Buenavista',
        'Carácuaro',
        'Charapan',
        'Charo',
        'Chavinda',
        'Cherán',
        'Chilchota',
        'Chinicuila',
        'Chucándiro',
        'Churintzio',
        'Churumuco',
        'Coahuayana',
        'Coalcomán de Vázquez Pallares',
        'Coeneo',
        'Cojumatlán de Régules',
        'Contepec',
        'Copándaro',
        'Cotija',
        'Cuitzeo',
        'Ecuandureo',
        'Epitacio Huerta',
        'Erongarícuaro',
        'Gabriel Zamora',
        'Hidalgo',
        'Huandacareo',
        'Huaniqueo',
        'Huetamo',
        'Huiramba',
        'Indaparapeo',
        'Irimbo',
        'Ixtlán',
        'Jacona',
        'Jiménez',
        'Jiquilpan',
        'José Sixto Verduzco',
        'Juárez',
        'Jungapeo',
        'La Huacana',
        'La Piedad',
        'Lagunillas',
        'Lázaro Cárdenas',
        'Los Reyes',
        'Madero',
        'Maravatío',
        'Marcos Castellanos',
        'Morelia',
        'Morelos',
        'Múgica',
        'Nahuatzen',
        'Nocupétaro',
        'Nuevo Parangaricutiro',
        'Nuevo Urecho',
        'Numarán',
        'Ocampo',
        'Pajacuarán',
        'Panindícuaro',
        'Paracho',
        'Parácuaro',
        'Pátzcuaro',
        'Penjamillo',
        'Peribán',
        'Purépero',
        'Puruándiro',
        'Queréndaro',
        'Quiroga',
        'Sahuayo',
        'Salvador Escalante',
        'San Lucas',
        'Santa Ana Maya',
        'Senguio',
        'Susupuato',
        'Tacámbaro',
        'Tancítaro',
        'Tangamandapio',
        'Tangancícuaro',
        'Tanhuato',
        'Taretan',
        'Tarímbaro',
        'Tepalcatepec',
        'Tingambato',
        'Tingüindín',
        'Tiquicheo de Nicolás Romero',
        'Tlalpujahua',
        'Tlazazalca',
        'Tocumbo',
        'Tumbiscatío',
        'Turicato',
        'Tuxpan',
        'Tuzantla',
        'Tzintzuntzan',
        'Tzitzio',
        'Uruapan',
        'Venustiano Carranza',
        'Villamar',
        'Vista Hermosa',
        'Yurécuaro',
        'Zacapu',
        'Zamora',
        'Zináparo',
        'Zinapécuaro',
        'Ziracuaretiro',
        'Zitácuaro',
      ];

        $estado = Estado::where('nombre', 'Michoacán de Ocampo')->first();

        foreach ($arr_municipios as $municipio){
          Municipio::updateOrCreate(
            ['nombre' => $municipio],
            [
              'estado_id' => $estado->id
            ]
          );
        }
    }
}
