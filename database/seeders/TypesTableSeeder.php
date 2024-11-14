<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types =  [
            [
                'name_type' => 'Almacen',
                'balance' => 0,
                'state'=>1
            ],
            [
                'name_type' => 'Caja Chica, Fonde en Avance, Reposiciones',
                'balance' => 2000,
                'state'=>1
            ],
        ];

        foreach ($types as $typeData) {
            Type::firstOrCreate(
                ['name_type' => $typeData['name_type']],
                ['balance' => $typeData['balance'], 'state'=>$typeData['state']]
            );
        }
    }
}
