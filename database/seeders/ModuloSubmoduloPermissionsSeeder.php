<?php

namespace Database\Seeders;

use App\Models\ModuloSubmoduloPermissions;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuloSubmoduloPermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    //Modulo Configuraciones
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => null, 'permission_id' => 1]);
    //Sub-Modulo Usuarios
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 1, 'permission_id' => 2]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 1, 'permission_id' => 3]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 1, 'permission_id' => 4]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 1, 'permission_id' => 5]);
    //Sub-Modulo Roles
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 2, 'permission_id' => 6]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 2, 'permission_id' => 7]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 2, 'permission_id' => 8]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 2, 'permission_id' => 9]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 2, 'permission_id' => 10]);
    //Sub-Modulo Permisos
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 3, 'permission_id' => 11]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 3, 'permission_id' => 12]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 3, 'permission_id' => 13]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 3, 'permission_id' => 14]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 1, 'submodulo_id' => 3, 'permission_id' => 15]);

    //Modulo Catalogos
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => null, 'permission_id' => 16]);
    //Sub-Modulo Afianzadoras
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 4, 'permission_id' => 17]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 4, 'permission_id' => 18]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 4, 'permission_id' => 19]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 4, 'permission_id' => 20]);
    //Sub-Modulo Estatus
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 5, 'permission_id' => 21]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 5, 'permission_id' => 22]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 5, 'permission_id' => 23]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 5, 'permission_id' => 24]);
    //Sub-Modulo Estado
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 6, 'permission_id' => 25]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 6, 'permission_id' => 26]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 6, 'permission_id' => 27]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 6, 'permission_id' => 28]);
    //Sub-Modulo Municipio
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 7, 'permission_id' => 29]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 7, 'permission_id' => 30]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 7, 'permission_id' => 31]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 7, 'permission_id' => 32]);
    //Sub-Modulo Colonias
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 8, 'permission_id' => 33]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 8, 'permission_id' => 34]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 8, 'permission_id' => 35]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 8, 'permission_id' => 36]);
    //Sub-Modulo Direccion
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 9, 'permission_id' => 37]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 9, 'permission_id' => 38]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 9, 'permission_id' => 39]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 9, 'permission_id' => 40]);
    //Sub-Modulo Tipo
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 10, 'permission_id' => 41]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 10, 'permission_id' => 42]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 10, 'permission_id' => 43]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 2, 'submodulo_id' => 10, 'permission_id' => 44]);

    //Modulo Operaciones
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => null, 'permission_id' => 45]);
    //Sub-Modulo Fianzas y Cheques
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 11, 'permission_id' => 46]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 11, 'permission_id' => 47]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 11, 'permission_id' => 48]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 11, 'permission_id' => 49]);
    //Sub-Modulo Cancelados
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 12, 'permission_id' => 50]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 12, 'permission_id' => 51]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 12, 'permission_id' => 52]);
    ModuloSubmoduloPermissions::updateOrCreate(['modulo_id' => 3, 'submodulo_id' => 12, 'permission_id' => 53]);
  }
}
