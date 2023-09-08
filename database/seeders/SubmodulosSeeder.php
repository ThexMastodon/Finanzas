<?php

namespace Database\Seeders;

use App\Models\Submodulo;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubmodulosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      //Modulo Configuracion
      Submodulo::updateOrCreate( ['nombre' => 'Usuarios'],['status'=>1, 'modulo_id' => 1, 'ruta' => 'lista','icono'=>'fas fa-fw fa-user']);
      Submodulo::updateOrCreate( ['nombre' => 'Roles'],['status'=>1,'modulo_id' => 1, 'ruta' => 'Roles','icono'=>'fas fa-fw fa-ban'] );
      Submodulo::updateOrCreate( ['nombre' => 'Permisos'],['status'=>1, 'modulo_id' => 1, 'ruta'=> 'Permisos','icono'=>'fas fa-fw fa-ban'] );

      //Modulo Catalogos
      Submodulo::updateOrCreate( ['nombre' => 'Afianzadoras'],['status'=>1,'modulo_id' => 2, 'ruta' => 'afianzadoras','icono'=>'fas fa-fw fa-grip-vertical']);
      Submodulo::updateOrCreate( ['nombre' => 'Estatus'],['status'=>1 ,'modulo_id' => 2, 'ruta' => 'Estatus','icono'=>'fas fa-fw fa-grip-vertical'] );
      Submodulo::updateOrCreate( ['nombre' => 'Estado'],['status'=>1 ,'modulo_id' => 2, 'ruta' => 'Estado','icono'=>'fas fa-fw fa-grip-vertical'] );
      Submodulo::updateOrCreate( ['nombre' => 'Municipio'],['status'=>1,'modulo_id' => 2, 'ruta' => 'Municipio','icono'=>'fas fa-fw fa-grip-vertical'] );
      Submodulo::updateOrCreate( ['nombre' => 'Colonias'],['status'=>1,'modulo_id' => 2, 'ruta' => 'Colonia','icono'=>'fas fa-fw fa-grip-vertical'] );
      Submodulo::updateOrCreate( ['nombre' => 'Dirección'],['status'=>1,'modulo_id' => 2, 'ruta' => 'Direccion','icono'=>'fas fa-fw fa-grip-vertical'] );
      Submodulo::updateOrCreate( ['nombre' => 'Tipo'],['status'=>1,'modulo_id' => 2, 'ruta' => 'Tipo','icono'=>'fas fa-fw fa-grip-vertical'] );

      //Modulo Operaciones
      Submodulo::updateOrCreate( ['nombre' => 'Fianzas/cheques'],['status'=>1,'modulo_id' => 3, 'ruta' => 'fianzas_cheques','icono'=>'fas fa-fw fa-copy']);
      Submodulo::updateOrCreate( ['nombre' => 'Cancelados'],['status'=>1,'modulo_id' => 3, 'ruta' => 'cancelados','icono'=>'fas fa-fw fa-ban' ]);

    }
}
