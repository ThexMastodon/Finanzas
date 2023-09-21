<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionsSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    //Permisos Configuraciones
    Permission::updateOrCreate(['name' => 'Ver Configuraciones'], ['tipo_permiso_id' => 4]); //1
    Permission::updateOrCreate(['name' => 'Ver Usuarios'], ['tipo_permiso_id' => 4]); //2
    Permission::updateOrCreate(['name' => 'crear Usuarios'], ['tipo_permiso_id' => 1]); //3
    Permission::updateOrCreate(['name' => 'Editar Usuarios'], ['tipo_permiso_id' => 2]); //4
    Permission::updateOrCreate(['name' => 'Eliminar Usuarios'], ['tipo_permiso_id' => 3]); //5
    Permission::updateOrCreate(['name' => 'Ver roles'], ['tipo_permiso_id' => 4]); //6
    Permission::updateOrCreate(['name' => 'crear roles'], ['tipo_permiso_id' => 1]); //7
    Permission::updateOrCreate(['name' => 'Asignar Roles'], ['tipo_permiso_id' => 2]); //8
    Permission::updateOrCreate(['name' => 'Editar roles'], ['tipo_permiso_id' => 2]); //9
    Permission::updateOrCreate(['name' => 'Eliminar roles'], ['tipo_permiso_id' => 3]); //10
    Permission::updateOrCreate(['name' => 'Ver Permisos'], ['tipo_permiso_id' => 4]); //11
    Permission::updateOrCreate(['name' => 'crear Permisos'], ['tipo_permiso_id' => 1]); //12
    Permission::updateOrCreate(['name' => 'Asignar Permisos'], ['tipo_permiso_id' => 2]); //13
    Permission::updateOrCreate(['name' => 'Editar Permisos'], ['tipo_permiso_id' => 2]); //14
    Permission::updateOrCreate(['name' => 'Eliminar Permisos'], ['tipo_permiso_id' => 3]); //15

    //Permisos Catalogos

    Permission::updateOrCreate(['name' => 'Ver Catalogos'], ['tipo_permiso_id' => 4]); //16
    Permission::updateOrCreate(['name' => 'Ver afianzadoras'], ['tipo_permiso_id' => 4]); //17
    Permission::updateOrCreate(['name' => 'crear afianzadoras'], ['tipo_permiso_id' => 1]); //18
    Permission::updateOrCreate(['name' => 'Editar afianzadoras'], ['tipo_permiso_id' => 2]); //19
    Permission::updateOrCreate(['name' => 'Eliminar afianzadoras'], ['tipo_permiso_id' => 3]); //20
    Permission::updateOrCreate(['name' => 'Ver Estatus'], ['tipo_permiso_id' => 4]); //21
    Permission::updateOrCreate(['name' => 'crear Estatus'], ['tipo_permiso_id' => 1]); //22
    Permission::updateOrCreate(['name' => 'Editar Estatus'], ['tipo_permiso_id' => 2]); //23
    Permission::updateOrCreate(['name' => 'Eliminar Estatus'], ['tipo_permiso_id' => 3]); //24
    Permission::updateOrCreate(['name' => 'Ver Estados'], ['tipo_permiso_id' => 4]); //25
    Permission::updateOrCreate(['name' => 'crear Estados'], ['tipo_permiso_id' => 1]); //26
    Permission::updateOrCreate(['name' => 'Editar Estados'], ['tipo_permiso_id' => 2]); //27
    Permission::updateOrCreate(['name' => 'Eliminar Estados'], ['tipo_permiso_id' => 3]); //28
    Permission::updateOrCreate(['name' => 'Ver Municipios'], ['tipo_permiso_id' => 4]); //29
    Permission::updateOrCreate(['name' => 'crear Municipios'], ['tipo_permiso_id' => 1]); //30
    Permission::updateOrCreate(['name' => 'Editar Municipios'], ['tipo_permiso_id' => 2]); //31
    Permission::updateOrCreate(['name' => 'Eliminar Municipios'], ['tipo_permiso_id' => 3]); //32
    Permission::updateOrCreate(['name' => 'Ver Colonia'], ['tipo_permiso_id' => 4]); //33
    Permission::updateOrCreate(['name' => 'crear Colonia'], ['tipo_permiso_id' => 1]); //34
    Permission::updateOrCreate(['name' => 'Editar Colonia'], ['tipo_permiso_id' => 2]); //35
    Permission::updateOrCreate(['name' => 'Eliminar Colonia'], ['tipo_permiso_id' => 3]); //36
    Permission::updateOrCreate(['name' => 'Ver direccion'], ['tipo_permiso_id' => 4]); //37
    Permission::updateOrCreate(['name' => 'crear direccion'], ['tipo_permiso_id' => 1]); //38
    Permission::updateOrCreate(['name' => 'Editar direccion'], ['tipo_permiso_id' => 2]); //39
    Permission::updateOrCreate(['name' => 'Eliminar direccion'], ['tipo_permiso_id' => 3]); //40
    Permission::updateOrCreate(['name' => 'Ver Tipo'], ['tipo_permiso_id' => 4]); //41
    Permission::updateOrCreate(['name' => 'crear Tipo'], ['tipo_permiso_id' => 1]); //42
    Permission::updateOrCreate(['name' => 'Editar Tipo'], ['tipo_permiso_id' => 2]); //43
    Permission::updateOrCreate(['name' => 'Eliminar Tipo'], ['tipo_permiso_id' => 3]); //44



    //Permisos Operaciones
    Permission::updateOrCreate(['name' => 'Ver operaciones'], ['tipo_permiso_id' => 4]); //45
    Permission::updateOrCreate(['name' => 'Ver Fianzas y cheques'], ['tipo_permiso_id' => 4]); //46
    Permission::updateOrCreate(['name' => 'crear Fianzas y cheques'], ['tipo_permiso_id' => 1]); //47
    Permission::updateOrCreate(['name' => 'Editar Fianzas y cheques'], ['tipo_permiso_id' => 2]); //48
    Permission::updateOrCreate(['name' => 'Eliminar Fianzas y cheques'], ['tipo_permiso_id' => 3]); //49
    Permission::updateOrCreate(['name' => 'Ver Cancelados'], ['tipo_permiso_id' => 4]); //50
    Permission::updateOrCreate(['name' => 'crear Cancelados'], ['tipo_permiso_id' => 1]); //51
    Permission::updateOrCreate(['name' => 'Editar Cancelados'], ['tipo_permiso_id' => 2]); //52
    Permission::updateOrCreate(['name' => 'Eliminar Cancelados'], ['tipo_permiso_id' => 3]); //53
  }
}
