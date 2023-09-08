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
    Permission::create(['name' => 'Ver Configuraciones','tipo_permiso_id'=>4]); //1
    Permission::create(['name' => 'Ver Usuarios','tipo_permiso_id'=>4]); //2
    Permission::create(['name' => 'crear Usuarios', 'tipo_permiso_id'=>1]); //3
    Permission::create(['name' => 'Editar Usuarios','tipo_permiso_id'=>2]); //4
    Permission::create(['name' => 'Eliminar Usuarios','tipo_permiso_id'=>3]); //5
    Permission::create(['name' => 'Ver roles','tipo_permiso_id'=>4]); //6
    Permission::create(['name' => 'crear roles','tipo_permiso_id'=>1]); //7
    Permission::create(['name' => 'Asignar Roles','tipo_permiso_id'=>2]); //8
    Permission::create(['name' => 'Editar roles','tipo_permiso_id'=>2]);  //9
    Permission::create(['name' => 'Eliminar roles','tipo_permiso_id'=>3]);  //10
    Permission::create(['name' => 'Ver Permisos','tipo_permiso_id'=>4]);  //11
    Permission::create(['name' => 'crear Permisos','tipo_permiso_id'=>1]);  //12
    Permission::create(['name' => 'Asignar Permisos','tipo_permiso_id'=>2]);  //13
    Permission::create(['name' => 'Editar Permisos','tipo_permiso_id'=>2]); //14
    Permission::create(['name' => 'Eliminar Permisos','tipo_permiso_id'=>3]); //15
    //Permisos Catalogos

    Permission::create(['name' => 'Ver Catalogos','tipo_permiso_id'=>4]); //16
    Permission::create(['name' => 'Ver afianzadoras','tipo_permiso_id'=>4]);  //17
    Permission::create(['name' => 'crear afianzadoras','tipo_permiso_id'=>1]);  //18
    Permission::create(['name' => 'Editar afianzadoras','tipo_permiso_id'=>2]); //19
    Permission::create(['name' => 'Eliminar afianzadoras','tipo_permiso_id'=>3]); //20
    Permission::create(['name' => 'Ver Estatus','tipo_permiso_id'=>4]); //21
    Permission::create(['name' => 'crear Estatus','tipo_permiso_id'=>1]); //22
    Permission::create(['name' => 'Editar Estatus','tipo_permiso_id'=>2]);  //23
    Permission::create(['name' => 'Eliminar Estatus','tipo_permiso_id'=>3]);  //24
    Permission::create(['name' => 'Ver Estados','tipo_permiso_id'=>4]); //25
    Permission::create(['name' => 'crear Estados','tipo_permiso_id'=>1]); //26
    Permission::create(['name' => 'Editar Estados','tipo_permiso_id'=>2]);  //27
    Permission::create(['name' => 'Eliminar Estados','tipo_permiso_id'=>3]);  //28
    Permission::create(['name' => 'Ver Municipios','tipo_permiso_id'=>4]);  //29
    Permission::create(['name' => 'crear Municipios','tipo_permiso_id'=>1]);  //30
    Permission::create(['name' => 'Editar Municipios','tipo_permiso_id'=>2]); //31
    Permission::create(['name' => 'Eliminar Municipios','tipo_permiso_id'=>3]); //32
    Permission::create(['name' => 'Ver Colonia','tipo_permiso_id'=>4]); //33
    Permission::create(['name' => 'crear Colonia','tipo_permiso_id'=>1]); //34
    Permission::create(['name' => 'Editar Colonia','tipo_permiso_id'=>2]);  //35
    Permission::create(['name' => 'Eliminar Colonia','tipo_permiso_id'=>3]);  //36
    Permission::create(['name' => 'Ver direccion','tipo_permiso_id'=>4]); //37
    Permission::create(['name' => 'crear direccion','tipo_permiso_id'=>1]); //38
    Permission::create(['name' => 'Editar direccion','tipo_permiso_id'=>2]);  //39
    Permission::create(['name' => 'Eliminar direccion','tipo_permiso_id'=>3]);  //40
    Permission::create(['name' => 'Ver Tipo','tipo_permiso_id'=>4]);  //41
    Permission::create(['name' => 'crear Tipo','tipo_permiso_id'=>1]);  //42
    Permission::create(['name' => 'Editar Tipo','tipo_permiso_id'=>2]); //43
    Permission::create(['name' => 'Eliminar Tipo','tipo_permiso_id'=>3]); //44


    //Permisos Operaciones
    Permission::create(['name' => 'Ver operaciones','tipo_permiso_id'=>4]); //45
    Permission::create(['name' => 'Ver Fianzas y cheques','tipo_permiso_id'=>4]); //46
    Permission::create(['name' => 'crear Fianzas y cheques','tipo_permiso_id'=>1]); //47
    Permission::create(['name' => 'Editar Fianzas y cheques','tipo_permiso_id'=>2]);  //48
    Permission::create(['name' => 'Eliminar Fianzas y cheques','tipo_permiso_id'=>3]);  //49
    Permission::create(['name' => 'Ver Cancelados','tipo_permiso_id'=>4]);  //50
    Permission::create(['name' => 'crear Cancelados','tipo_permiso_id'=>1]);   //51
    Permission::create(['name' => 'Editar Cancelados','tipo_permiso_id'=>2]); //52
    Permission::create(['name' => 'Eliminar Cancelados','tipo_permiso_id'=>3]); //53
  }
}
