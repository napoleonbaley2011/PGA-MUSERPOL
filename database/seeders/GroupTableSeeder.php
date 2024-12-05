<?php

namespace Database\Seeders;

use App\Models\Group;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $groups = [
            [
                'code' => '31100',
                'name_group' => 'Alimentos y Bebidas para Personas, Desayuno Escolar y Otros',
                'state' => 'active',
                'classifier_id' => 1
            ],
            [
                'code' => '31120',
                'name_group' => 'Gastos por Alimentación y Otros Similares',
                'state' => 'active',
                'classifier_id' => 1
            ],
            [
                'code' => '31200',
                'name_group' => ' Alimentos para Animales',
                'state' => 'active',
                'classifier_id' => 1
            ],
            [
                'code' => '31300',
                'name_group' => 'Productos Agrícolas, Pecuarios y Forestales',
                'state' => 'active',
                'classifier_id' => 1
            ],
            [
                'code' => '32100',
                'name_group' => 'Papel',
                'state' => 'active',
                'classifier_id' => 2
            ],
            [
                'code' => '32200',
                'name_group' => 'Productos de Artes Gráficas',
                'state' => 'active',
                'classifier_id' => 2
            ],
            [
                'code' => '32300',
                'name_group' => 'Libros, Manuales y Revistas',
                'state' => 'active',
                'classifier_id' => 2
            ],
            [
                'code' => '32400',
                'name_group' => 'Textos de Enseñanza',
                'state' => 'active',
                'classifier_id' => 2
            ],
            [
                'code' => '32500',
                'name_group' => 'Periódicos y Boletines',
                'state' => 'active',
                'classifier_id' => 2
            ],
            [
                'code' => '33100',
                'name_group' => 'Hilados, Telas, Fibras y Algodón',
                'state' => 'active',
                'classifier_id' => 3
            ],
            [
                'code' => '33200',
                'name_group' => 'Confecciones Textiles',
                'state' => 'active',
                'classifier_id' => 3
            ],
            [
                'code' => '33300',
                'name_group' => 'Prendas de Vestir',
                'state' => 'active',
                'classifier_id' => 3
            ],
            [
                'code' => '33400',
                'name_group' => 'Calzados',
                'state' => 'active',
                'classifier_id' => 3
            ],
            [
                'code' => '34100',
                'name_group' => 'Combustibles, Lubricantes, Derivados y otras Fuentes de Energía ',
                'state' => 'active',
                'classifier_id' => 3
            ],
            [
                'code' => '34200',
                'name_group' => 'Productos Químicos y Farmacéuticos',
                'state' => 'active',
                'classifier_id' => 3
            ],
            [
                'code' => '33400',
                'name_group' => 'Calzados',
                'state' => 'active',
                'classifier_id' => 3
            ],
            [
                'code' => '34100',
                'name_group' => 'Combustibles, Lubricantes, Derivados y otras Fuentes de Energía ',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34200',
                'name_group' => 'Productos Químicos y Farmacéuticos',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34300',
                'name_group' => 'Llantas y Neumáticos',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34400',
                'name_group' => 'Productos de Cuero y Caucho',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34500',
                'name_group' => 'Productos de Minerales no Metálicos y Plásticos',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34600',
                'name_group' => 'Productos Metálicos',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34700',
                'name_group' => 'Minerales',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34800',
                'name_group' => 'Herramientas Menores',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '34900',
                'name_group' => 'Material y Equipo Militar',
                'state' => 'active',
                'classifier_id' => 4
            ],
            [
                'code' => '39100',
                'name_group' => 'Material de Limpieza e Higiene',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39200',
                'name_group' => 'Material Deportivo y Recreativo',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39300',
                'name_group' => 'Utensilios de Cocina y Comedor',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39400',
                'name_group' => 'Instrumental Menor Médico-Quirúrgico',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39500',
                'name_group' => 'Útiles de Escritorio y Oficina',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39600',
                'name_group' => 'Útiles Educacionales, Culturales y de Capacitación',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39700',
                'name_group' => 'Útiles y Materiales Eléctricos',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39800',
                'name_group' => 'Otros Repuestos y Accesorios',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39900',
                'name_group' => 'Otros Materiales y Suministros',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39910',
                'name_group' => 'Acuñación de Monedas e Impresión de Billetes',
                'state' => 'active',
                'classifier_id' => 5
            ],
            [
                'code' => '39990',
                'name_group' => 'Otros Materiales y Suministros',
                'state' => 'active',
                'classifier_id' => 5
            ],

            [
                'code' => '21100',
                'name_group' => 'Comunicaciones',
                'state' => 'active',
                'classifier_id' => 6
            ],
            [
                'code' => '21200',
                'name_group' => 'Energía Eléctrica',
                'state' => 'active',
                'classifier_id' => 6
            ],
            [
                'code' => '21300',
                'name_group' => 'Agua',
                'state' => 'active',
                'classifier_id' => 6
            ],
            [
                'code' => '21400',
                'name_group' => 'Telefonía',
                'state' => 'active',
                'classifier_id' => 6
            ],
            [
                'code' => '21500',
                'name_group' => 'Gas Domiciliario',
                'state' => 'active',
                'classifier_id' => 6
            ],
            [
                'code' => '21600',
                'name_group' => 'Internet',
                'state' => 'active',
                'classifier_id' => 6
            ],
            [
                'code' => '22300',
                'name_group' => 'Fletes y Almacenamiento',
                'state' => 'active',
                'classifier_id' => 7
            ],
            [
                'code' => '22500',
                'name_group' => 'Seguros',
                'state' => 'active',
                'classifier_id' => 7
            ],
            [
                'code' => '22600',
                'name_group' => 'Transporte de Personal',
                'state' => 'active',
                'classifier_id' => 7
            ],
            [
                'code' => '23200',
                'name_group' => 'Alquiler de Equipos y Maquinarias',
                'state' => 'active',
                'classifier_id' => 8
            ],
            [
                'code' => '23400',
                'name_group' => 'Otros Alquileres',
                'state' => 'active',
                'classifier_id' => 8
            ],
            [
                'code' => '24120',
                'name_group' => 'Mantenimiento y Reparación de Vehículos, Maquinaria y Equipos',
                'state' => 'active',
                'classifier_id' => 9
            ],
            [
                'code' => '24130',
                'name_group' => 'Mantenimiento y Reparación de Muebles y Enseres',
                'state' => 'active',
                'classifier_id' => 9
            ],
            [
                'code' => '24300',
                'name_group' => 'Otros Gastos por Concepto de Instalación, Mantenimiento y Reparación',
                'state' => 'active',
                'classifier_id' => 9
            ],
            // Classifier ID 10
            [
                'code' => '25400',
                'name_group' => 'Lavandería, Limpieza e Higiene',
                'state' => 'active',
                'classifier_id' => 10
            ],
            [
                'code' => '25500',
                'name_group' => 'Publicidad',
                'state' => 'active',
                'classifier_id' => 10
            ],
            [
                'code' => '25600',
                'name_group' => 'Servicios de Imprenta, Fotocopiado y Fotográficos',
                'state' => 'active',
                'classifier_id' => 10
            ],
            [
                'code' => '25900',
                'name_group' => 'Servicios Manuales',
                'state' => 'active',
                'classifier_id' => 10
            ],
            // Classifier ID 11
            [
                'code' => '26200',
                'name_group' => 'Gastos Judiciales',
                'state' => 'active',
                'classifier_id' => 11
            ],
            [
                'code' => '26990',
                'name_group' => 'Otros',
                'state' => 'active',
                'classifier_id' => 11
            ],
            // Classifier ID 12
            [
                'code' => '85100',
                'name_group' => 'Tasas',
                'state' => 'active',
                'classifier_id' => 12
            ],
            [
                'code' => '86100',
                'name_group' => 'Patentes',
                'state' => 'active',
                'classifier_id' => 12
            ],

        ];

        foreach ($groups as $groupData) {
            Group::firstOrCreate(
                ['code' => $groupData['code']],
                ['name_group' => $groupData['name_group'], 'state' => $groupData['state'], 'classifier_id' => $groupData['classifier_id']]
            );
        }
    }
}
