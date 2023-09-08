<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class Role_has_PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      $lectorRole = Role::findByName('lector');
      $lectorRole->givePermissionTo('Ver Cancelados');
      $lectorRole->givePermissionTo('Ver Fianzas y cheques');
      $lectorRole->givePermissionTo('Ver Tipo');
      $lectorRole->givePermissionTo('Ver direccion');
      $lectorRole->givePermissionTo('Ver Colonia');
      $lectorRole->givePermissionTo('Ver Municipios');
      $lectorRole->givePermissionTo('Ver Estados');
      $lectorRole->givePermissionTo('Ver Estatus');
      $lectorRole->givePermissionTo('Ver Catalogos');
      $lectorRole->givePermissionTo('Ver operaciones');
      $lectorRole->givePermissionTo('Ver afianzadoras');

      $editorRole = Role::findByName('editor');
      $editorRole->givePermissionTo('Ver Cancelados');
      $editorRole->givePermissionTo('Ver Fianzas y cheques');
      $editorRole->givePermissionTo('Ver Tipo');
      $editorRole->givePermissionTo('Ver direccion');
      $editorRole->givePermissionTo('Ver Colonia');
      $editorRole->givePermissionTo('Ver Municipios');
      $editorRole->givePermissionTo('Ver Estados');
      $editorRole->givePermissionTo('Ver Estatus');
      $editorRole->givePermissionTo('Editar Cancelados');
      $editorRole->givePermissionTo('Editar Fianzas y cheques');
      $editorRole->givePermissionTo('Editar Tipo');
      $editorRole->givePermissionTo('Editar direccion');
      $editorRole->givePermissionTo('Editar Colonia');
      $editorRole->givePermissionTo('Editar Municipios');
      $editorRole->givePermissionTo('Editar Estados');
      $editorRole->givePermissionTo('Editar Estatus');
      $editorRole->givePermissionTo('Ver Catalogos');
      $editorRole->givePermissionTo('Ver operaciones');
      $editorRole->givePermissionTo('Ver afianzadoras');
      $editorRole->givePermissionTo('Editar afianzadoras');



      $administradorRole = Role::findByName('administrador');
      $administradorRole->givePermissionTo('Ver Cancelados');
      $administradorRole->givePermissionTo('Ver Fianzas y cheques');
      $administradorRole->givePermissionTo('Ver Tipo');
      $administradorRole->givePermissionTo('Ver direccion');
      $administradorRole->givePermissionTo('Ver Colonia');
      $administradorRole->givePermissionTo('Ver Municipios');
      $administradorRole->givePermissionTo('Ver Estados');
      $administradorRole->givePermissionTo('Ver Estatus');
      $administradorRole->givePermissionTo('Editar Cancelados');
      $administradorRole->givePermissionTo('Editar Fianzas y cheques');
      $administradorRole->givePermissionTo('Editar Tipo');
      $administradorRole->givePermissionTo('Editar direccion');
      $administradorRole->givePermissionTo('Editar Colonia');
      $administradorRole->givePermissionTo('Editar Municipios');
      $administradorRole->givePermissionTo('Editar Estados');
      $administradorRole->givePermissionTo('Editar Estatus');
      $administradorRole->givePermissionTo('Eliminar Cancelados');
      $administradorRole->givePermissionTo('Eliminar Fianzas y cheques');
      $administradorRole->givePermissionTo('Eliminar Tipo');
      $administradorRole->givePermissionTo('Eliminar direccion');
      $administradorRole->givePermissionTo('Eliminar Colonia');
      $administradorRole->givePermissionTo('Eliminar Municipios');
      $administradorRole->givePermissionTo('Eliminar Estados');
      $administradorRole->givePermissionTo('Eliminar Estatus');
      $administradorRole->givePermissionTo('crear Cancelados');
      $administradorRole->givePermissionTo('crear Fianzas y cheques');
      $administradorRole->givePermissionTo('crear Tipo');
      $administradorRole->givePermissionTo('crear direccion');
      $administradorRole->givePermissionTo('crear Colonia');
      $administradorRole->givePermissionTo('crear Municipios');
      $administradorRole->givePermissionTo('crear Estados');
      $administradorRole->givePermissionTo('crear Estatus');
      $administradorRole->givePermissionTo('Ver Catalogos');
      $administradorRole->givePermissionTo('Ver operaciones');
      $administradorRole->givePermissionTo('Ver afianzadoras');
      $administradorRole->givePermissionTo('crear afianzadoras');

      $administradorRole->givePermissionTo('Editar afianzadoras');
      $administradorRole->givePermissionTo('Eliminar afianzadoras');

      $rootRole = Role::findByName('root');
      $rootRole->givePermissionTo('Ver Cancelados');
      $rootRole->givePermissionTo('Ver Fianzas y cheques');
      $rootRole->givePermissionTo('Ver Tipo');
      $rootRole->givePermissionTo('Ver direccion');
      $rootRole->givePermissionTo('Ver Colonia');
      $rootRole->givePermissionTo('Ver Municipios');
      $rootRole->givePermissionTo('Ver Estados');
      $rootRole->givePermissionTo('Ver Estatus');
      $rootRole->givePermissionTo('Editar Cancelados');
      $rootRole->givePermissionTo('Editar Fianzas y cheques');
      $rootRole->givePermissionTo('Editar Tipo');
      $rootRole->givePermissionTo('Editar direccion');
      $rootRole->givePermissionTo('Editar Colonia');
      $rootRole->givePermissionTo('Editar Municipios');
      $rootRole->givePermissionTo('Editar Estados');
      $rootRole->givePermissionTo('Editar Estatus');
      $rootRole->givePermissionTo('Eliminar Cancelados');
      $rootRole->givePermissionTo('Eliminar Fianzas y cheques');
      $rootRole->givePermissionTo('Eliminar Tipo');
      $rootRole->givePermissionTo('Eliminar direccion');
      $rootRole->givePermissionTo('Eliminar Colonia');
      $rootRole->givePermissionTo('Eliminar Municipios');
      $rootRole->givePermissionTo('Eliminar Estados');
      $rootRole->givePermissionTo('Eliminar Estatus');
      $rootRole->givePermissionTo('crear Cancelados');
      $rootRole->givePermissionTo('crear Fianzas y cheques');
      $rootRole->givePermissionTo('crear Tipo');
      $rootRole->givePermissionTo('crear direccion');
      $rootRole->givePermissionTo('crear Colonia');
      $rootRole->givePermissionTo('crear Municipios');
      $rootRole->givePermissionTo('crear Estados');
      $rootRole->givePermissionTo('crear Estatus');
      $rootRole->givePermissionTo('Ver Configuraciones');
      $rootRole->givePermissionTo('Ver Catalogos');
      $rootRole->givePermissionTo('Ver operaciones');
      $rootRole->givePermissionTo('Ver Usuarios');
      $rootRole->givePermissionTo('crear Usuarios');
      $rootRole->givePermissionTo('Editar Usuarios');
      $rootRole->givePermissionTo('Eliminar Usuarios');
      $rootRole->givePermissionTo('Ver roles');
      $rootRole->givePermissionTo('crear roles');
      $rootRole->givePermissionTo('Asignar Roles');
      $rootRole->givePermissionTo('Editar roles');
      $rootRole->givePermissionTo('Eliminar roles');
      $rootRole->givePermissionTo('Ver Permisos');
      $rootRole->givePermissionTo('crear Permisos');
      $rootRole->givePermissionTo('Asignar Permisos');
      $rootRole->givePermissionTo('Editar Permisos');
      $rootRole->givePermissionTo('Eliminar Permisos');
      $rootRole->givePermissionTo('Ver afianzadoras');
      $rootRole->givePermissionTo('crear afianzadoras');

      $rootRole->givePermissionTo('Editar afianzadoras');
      $rootRole->givePermissionTo('Eliminar afianzadoras');
      $usuario = User::find(1);
       $rol = Role::findByName('root');

     $usuario->assignRole($rol);
    }
}
