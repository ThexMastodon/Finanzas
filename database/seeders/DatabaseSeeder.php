<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            EstadosSeeder::class,
            MunicipiosSeeder::class,
            ColoniasSeeder::class,
            RolesSeeder::class,
            ModulosSeeder::class,
            SubmodulosSeeder::class,
            TipoPermiso::class,
            PermissionsSeeder::class,
            ModuloSubmoduloPermissionsSeeder::class,
            Role_has_PermissionsSeeder::class,
            EstatusSeeder::class,
            TipoSeeder::class,
            AfianzadorasSeeder::class,
            BD_historicoSeeder::class,
        ]);
    }
}
