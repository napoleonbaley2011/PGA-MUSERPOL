<?php

namespace Database\Seeders;

use App\Models\UserStore;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserStoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rols =  [
            [
                'name_user' => 'jcoca',
                'rol' => 'Aprobador',
                'active' => true
            ],
        ];

        foreach ($rols as $rol) {
            UserStore::firstOrCreate(
                ['name_user' => $rol['name_user']],
                ['rol' => $rol['rol'], 'active' => $rol['active']]
            );
        }
    }
}
