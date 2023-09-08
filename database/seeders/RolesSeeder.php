<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
class RolesSeeder extends Seeder
{


  // // Definir el rol "editor"

    public function run(): void
    {
      Role::create(['name' => 'root']);
      Role::create(['name' => 'administrador']);
      Role::create(['name' => 'editor']);
      Role::create(['name' => 'lector']);

     // // Definir el permiso para acceder a la vista específica

    }
}
