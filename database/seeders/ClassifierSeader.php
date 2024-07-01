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
        $classifiers = [
            [
                'code_class' => '31000',
                'nombre' => 'Alimentos y Productos Agroforestales',
                'description' => 'Gastos destinados a la adquisición de bebidas y productos alimenticios, manufacturados o no,
                incluye animales vivos para consumo, aceites, grasas animales y vegetales, forrajes y otros
                alimentos para animales; además, comprende productos agrícolas, ganaderos, de silvicultura,
                caza y pesca. Comprende madera y productos de este material.'
            ],
            [
                'code_class' => '32000',
                'nombre' => 'Productos de Papel, Cartón e Impresos',
                'description' => 'Gastos destinados a la adquisición de papel y cartón en sus diversas formas y clases; libros y
                revistas, textos de enseñanza, compra y suscripción de periódicos.'
            ],
            [
                'code_class' => '33000',
                'nombre' => 'Textiles y Vestuario',
                'description' => 'Gastos para la compra de ropa de trabajo, vestuario, uniformes, adquisición de calzados, hilados,
                telas de lino, algodón, seda, lana, fibras artificiales y tapices, alfombras, sábanas, toallas, sacos de 
                fibras y otros artículos conexos de cáñamo, yute y otros.'
            ],
            [
                'code_class' => '34000',
                'nombre' => 'Combustibles, Productos Químicos, Farmacéuticos y Otras Fuentes de Energía',
                'description' => 'Gastos destinados a la adquisición de papel y cartón en sus diversas formas y clases; libros y
                revistas, textos de enseñanza, compra y suscripción de periódicos.'
            ],
            [
                'code_class' => '39000',
                'nombre' => 'Productos Varios',
                'description' => 'Gastos en productos de limpieza, material deportivo, utensilios de cocina y comedor, instrumental
                menor médico-quirúrgico, útiles de escritorio, de oficina y enseñanza, materiales eléctricos,
                repuestos y accesorios en general.'
            ],

        ];

        foreach ($classifiers as $classifierData) {
            Classifier::firstOrCreate(
                ['code_class' => $classifierData['code_class']],
                ['nombre' => $classifierData['nombre'], 'description' => $classifierData['description']],
            );
        }
    }
}
