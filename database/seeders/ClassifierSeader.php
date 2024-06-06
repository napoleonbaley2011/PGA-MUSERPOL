<?php

namespace Database\Seeders;

use App\Models\Classifier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassifierSeader extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $classifiers= [
            [
             'code_class' => '31000',
             'nombre'=>'Alimentos y Productos Agroforestales',
             'description'=>'Gastos destinados a la adquisición de bebidas y productos alimenticios, manufacturados o no, incluye animales vivos para consumo, aceites, grasas animales y vegetales, forrajes y otros alimentos para animales; además, comprende productos agrícolas, ganaderos, de silvicultura, caza y pesca. Comprende madera y productos de este material.'
            ],
            [
             'code_class' => '32000',
             'nombre'=>'Productos de Papel, Cartón e Impresos',
             'description'=>'Gastos destinados a la adquisición de bebidas y productos alimenticios, manufacturados o no, incluye animales vivos para consumo, aceites, grasas animales y vegetales, forrajes y otros alimentos para animales; además, comprende productos agrícolas, ganaderos, de silvicultura, caza y pesca. Comprende madera y productos de este material.'
            ],
            [
             'code_class' => '33000',
             'nombre'=>'Textiles y Vestuario',
             'description'=>'Gastos destinados a la adquisición de bebidas y productos alimenticios, manufacturados o no, incluye animales vivos para consumo, aceites, grasas animales y vegetales, forrajes y otros alimentos para animales; además, comprende productos agrícolas, ganaderos, de silvicultura, caza y pesca. Comprende madera y productos de este material.'
            ],
            [
             'code_class' => '34000',
             'nombre'=>'Combustibles',
             'description'=>'Gastos destinados a la adquisición de bebidas y productos alimenticios, manufacturados o no, incluye animales vivos para consumo, aceites, grasas animales y vegetales, forrajes y otros alimentos para animales; además, comprende productos agrícolas, ganaderos, de silvicultura, caza y pesca. Comprende madera y productos de este material.'
            ],
            [
             'code_class' => '39000',
             'nombre'=>'Productos Varios',
             'description'=>'Gastos destinados a la adquisición de bebidas y productos alimenticios, manufacturados o no, incluye animales vivos para consumo, aceites, grasas animales y vegetales, forrajes y otros alimentos para animales; además, comprende productos agrícolas, ganaderos, de silvicultura, caza y pesca. Comprende madera y productos de este material.'
            ]   

        ];

        foreach($classifiers as $classifierData){
            Classifier::firstOrCreate(
                ['code_class' => $classifierData['code_class']],
                ['nombre'=>$classifierData['nombre'], 'description'=>$classifierData['description']],
            );
        }
    }
}
