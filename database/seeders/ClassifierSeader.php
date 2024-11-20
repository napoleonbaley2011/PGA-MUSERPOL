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
            [
                'code_class' => '21000',
                'nombre' => 'Servicios Basicos',
                'description' => 'Gastos por comunicaciones y servicios necesarios para el funcionamiento de las entidades, proporcionados o producidos por empresas del sector público o privado.'
            ],

            [
                'code_class' => '22000',
                'nombre' => 'Servicios de Transporte y Seguros',
                'description' => 'Gastos por transporte de bienes al interior y exterior del país, transporte de personal, gastos de pasajes y viáticos para personal permanente, eventual y consultores individuales de línea, de acuerdo a contrato establecido, cuando corresponda, facultados por autoridad competente, así como gastos de instalación y retorno de funcionarios destinados en el exterior del país, incluye gastos por contratación de seguros.'
            ],

            [
                'code_class' => '23000',
                'nombre' => 'Alquileres',
                'description' => 'Gastos por alquileres de bienes muebles, inmuebles, equipos, maquinarias y otros de propiedad de terceros.'
            ],

            [
                'code_class' => '24000',
                'nombre' => 'Instalación, Mantenimiento y Reparaciones',
                'description' => 'Asignaciones destinadas a la conservación de edificios, equipos, vías de comunicación y otros bienes de uso público, así como la conversión de vehículos a gas natural, ejecutados por terceros.'
            ],
            [
                'code_class' => '25000',
                'nombre' => 'Servicios Profesionales y Comerciales',
                'description' => 'Gastos por servicios profesionales de asesoramiento especializado, por estudios e investigaciones específicas de acuerdo a normativa vigente. Comprende pagos de comisiones y gastos bancarios, excepto los relativos a la deuda pública. Se incluyen gastos por servicios sanitarios, médicos, sociales, de lavandería, publicidad e imprenta, ejecutados por terceros.'
            ],

            [
                'code_class' => '26000',
                'nombre' => 'Otros Servicios No Personales',
                'description' => 'Otros Servicios No Personales.'
            ],

            [
                'code_class' => '85000',
                'nombre' => 'Tasas, Multas y Otros',
                'description' => 'Gastos realizados por las instituciones públicas destinados al pago por concepto de tasas, derechos, multas, intereses penales, acuotaciones y otros.'
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
