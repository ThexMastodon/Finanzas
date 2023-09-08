<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                'name' => 'Edgar',
                'last_name' => 'Morales',
                'second_last_name' => null,
                'username' => 'edgarmorales',
                'email' => 'dev.edgarmorales@gmail.com',
                'password' => bcrypt('admin123'),
                'active' => true,
                'image' => null
            ],
            [
              'name' => 'Blanca',
              'last_name' => 'Vallejo',
              'second_last_name' => null,
              'username' => 'blanca.v',
              'email' => 'estelavalledelatorre@gmail.com',
              'password' => bcrypt('12345678'),
              'active' => true,
              'image' => null
            ]
        ];

        foreach ($data as $user) {
            User::create($user);
        }
    }
}
