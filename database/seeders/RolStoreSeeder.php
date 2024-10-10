<?php

namespace Database\Seeders;

use App\Models\RolStore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            ['name_rol' => 'Aprobador'],
            ['name_rol' => 'Operador'],
            ['name_rol' => 'Consultas']
        ];

        foreach ($roles as $rol) {
            RolStore::firstOrCreate(
                ['name_rol' => $rol['name_rol']]
            );
        }
    }
}
