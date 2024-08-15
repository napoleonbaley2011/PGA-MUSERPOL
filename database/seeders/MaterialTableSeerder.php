<?php

namespace Database\Seeders;

use App\Models\Material;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MaterialTableSeerder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $materials = [
            [
                'code_material' => '321005',
                'description' => 'PAPEL BOND TAMAÑO OFICIO',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1001',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '321006',
                'description' => 'PAPEL BOND TAMAÑO RESMA',
                'unit_material' => 'HOJA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1002',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '321008',
                'description' => 'PAPEL CEBOLLA TAMAÑO OFICIO',
                'unit_material' => 'HOJA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1003',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '321009',
                'description' => 'PAPEL CEBOLLA TAMAÑO RESMA',
                'unit_material' => 'HOJA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1004',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210011',
                'description' => 'PAPEL PARA FAX',
                'unit_material' => 'ROLLO',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1005',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210033',
                'description' => 'PAPEL BOND TAMAÑO CARTA COLOR VERDE',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1006',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210034',
                'description' => 'PAPEL BOND TAMAÑO CARTA',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1007',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210036',
                'description' => 'PAPEL TERMICO PARA COMANDAS 79 MM.',
                'unit_material' => 'ROLLO',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1008',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210037',
                'description' => 'PAPEL BOND TAMAÑO CARTA DE DIFERENTES COLORES',
                'unit_material' => 'HOJA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1009',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210038',
                'description' => 'CUADERNILLO AMARILLO DE 14 COLUMNAS',
                'unit_material' => 'BLOCK',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1010',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210039',
                'description' => 'CUADERNILLO TAMAÑO OFICIO',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1011',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210040',
                'description' => 'PAPEL TAMAÑO CARTA COLOR ROSADO SUAVE',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1012',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210042',
                'description' => 'PAPEL TAMAÑO OFICIO',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1014',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210043',
                'description' => 'HOJAS DE COLORES CARTA',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1015',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210044',
                'description' => 'HOJAS DE COLORES OFICIO',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1016',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210045',
                'description' => 'PAPEL TAMAÑO CARTA DIFERENTES COLORES',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1017',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210046',
                'description' => 'HOJAS COLOR',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1018',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210047',
                'description' => 'PAPEL TAMAÑO CARTA COLOR AMARILLO SUAVE',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1019',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210048',
                'description' => 'PAPEL TAMAÑO CARTA AMARILLO',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1020',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210049',
                'description' => 'PAPEL TAMAÑO CARTA COLOR VERDE SUAVE',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1021',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '3210050',
                'description' => 'PAPEL TAMAÑO CARTA COLOR CELESTE SUAVE',
                'unit_material' => 'PAQUETE',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1022',
                'type' => 'Almacen',
                'group_id' => 4
            ],
            [
                'code_material' => '322001',
                'description' => 'FORMULARIO ANTICIPO RENTAS PASIVO (MUSEPOL)',
                'unit_material' => 'BLOCK',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1023',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322002',
                'description' => 'FORMULARIO BENEFICIOS HABITUALES (MUSEPOL)',
                'unit_material' => 'BLOCK',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1024',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322003',
                'description' => 'FOLDER DISEÑADO BENEFICIO DE AUXILIO MORTUORIO',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1025',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322004',
                'description' => 'FORMULARIO CERTIFICACION ARCHIVO PRESTACIONES (MUSEPOL)',
                'unit_material' => 'BLOCK',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1026',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322005',
                'description' => 'FOLDER DISEÑADO COMPLEMENTO 2016',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1027',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322006',
                'description' => 'FORMULARIO DE SALIDA DE RECURSOS HUMANOS',
                'unit_material' => 'BLOCK',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1028',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322007',
                'description' => 'FOLDER DISEÑADO BENEFICIO DE CUOTA MORTUORIA',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1029',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322008',
                'description' => 'FOLDER DISEÑADO COMPLEMENTO ECONOMICO (CON LOGO)',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1030',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '322009',
                'description' => 'FORMULARIO HOJA DE TRAMITE (MUSEPOL)',
                'unit_material' => 'BLOCK',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1031',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '3220010',
                'description' => 'FOLDER DISEÑADO EXPEDIENTE PAGO PRESTACIONES (MUSEPOL)',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1032',
                'type' => 'Almacen',
                'group_id' => 5
            ],
        ];

        foreach ($materials as $materialData) {
            Material::firstOrCreate(
                ['code_material' => $materialData['code_material']],
                [
                    'description' => $materialData['description'],
                    'unit_material' => $materialData['unit_material'],
                    'state' => $materialData['state'],
                    'stock' => $materialData['stock'],
                    'min' => $materialData['min'],
                    'barcode' => $materialData['barcode'],
                    'type' => $materialData['type'],
                    'group_id' => $materialData['group_id']
                ]
            );
        }
    }
}
