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
                'code_material' => '321002',
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
                'code_material' => '321003',
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
                'code_material' => '321004',
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
                'code_material' => '321005',
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
                'code_material' => '321006',
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
                'code_material' => '321007',
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
                'code_material' => '321008',
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
                'code_material' => '321009',
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
                'code_material' => '3210010',
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
                'code_material' => '3210011',
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
                'code_material' => '3210012',
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
                'code_material' => '3210013',
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
                'code_material' => '3210014',
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
                'code_material' => '3210015',
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
                'code_material' => '3210016',
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
                'code_material' => '3210017',
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
                'code_material' => '3210018',
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
                'code_material' => '3210019',
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
                'code_material' => '3210020',
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
                'code_material' => '3210021',
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
                'code_material' => '3210022',
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
                'code_material' => '322002',
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
                'code_material' => '322003',
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
                'code_material' => '322004',
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
                'code_material' => '322005',
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
                'code_material' => '322006',
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
                'code_material' => '322007',
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
                'code_material' => '322008',
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
                'code_material' => '322009',
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
                'code_material' => '3220010',
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
                'code_material' => '3220011',
                'description' => 'FOLDER DISEÑADO EXPEDIENTE PAGO PRESTACIONES (MUSEPOL)',
                'unit_material' => 'PIEZA',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1032',
                'type' => 'Almacen',
                'group_id' => 5
            ],
            [
                'code_material' => '311001',
                'description' => '31100 - ALIMENTOS Y BEBIDAS PARA PERSONAS, DESAYUNO ESCOLAR Y OTROS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1033',
                'type' => 'Caja Chica',
                'group_id' => 1
            ],
            [
                'code_material' => '312001',
                'description' => '32100 - ALIMENTOS PARA ANIMALES (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1034',
                'type' => 'Caja Chica',
                'group_id' => 2
            ],
            [
                'code_material' => '313001',
                'description' => '31300 - PRODUCTOS AGRÍCOLAS, PECUARIOS Y FORESTALES (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1035',
                'type' => 'Caja Chica',
                'group_id' => 3
            ],
            [
                'code_material' => '321001',
                'description' => '32100 - PAPEL (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1036',
                'type' => 'Caja Chica',
                'group_id' => 4
            ],
            [
                'code_material' => '322001',
                'description' => '32200 - PRODUCTOS DE ARTES GRÁFICAS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1037',
                'type' => 'Caja Chica',
                'group_id' => 5
            ],
            [
                'code_material' => '323001',
                'description' => '32300 - LIBROS, MANUALES Y REVISTAS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1038',
                'type' => 'Caja Chica',
                'group_id' => 6
            ],
            [
                'code_material' => '324001',
                'description' => '32400 - TEXTOS DE ENSEÑANZA (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1039',
                'type' => 'Caja Chica',
                'group_id' => 7
            ],
            [
                'code_material' => '325001',
                'description' => '32500 - PERIÓDICOS Y BOLETINES (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1040',
                'type' => 'Caja Chica',
                'group_id' => 8
            ],
            [
                'code_material' => '331001',
                'description' => '33100 - HILADOS, TELAS, FIBRAS Y ALGODÓN (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1041',
                'type' => 'Caja Chica',
                'group_id' => 9
            ],
            [
                'code_material' => '332001',
                'description' => '332001 - CONFECCIONES TEXTILES (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1042',
                'type' => 'Caja Chica',
                'group_id' => 10
            ],
            [
                'code_material' => '333001',
                'description' => '333001 - PRENDAS DE VESTIR (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1043',
                'type' => 'Caja Chica',
                'group_id' => 11
            ],
            [
                'code_material' => '334001',
                'description' => '33400 - CALZADOS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1044',
                'type' => 'Caja Chica',
                'group_id' => 12
            ],
            [
                'code_material' => '341001',
                'description' => '34100 - COMBUSTIBLES, LUBRICANTES, DERIVADOS Y OTRAS FUENTES DE ENERGÍA (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1045',
                'type' => 'Caja Chica',
                'group_id' => 13
            ],
            [
                'code_material' => '342001',
                'description' => '34200 - PRODUCTOS QUÍMICOS Y FARMACÉUTICOS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1046',
                'type' => 'Caja Chica',
                'group_id' => 14
            ],
            [
                'code_material' => '343001',
                'description' => '34300 - LLANTAS Y NEUMÁTICOS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1047',
                'type' => 'Caja Chica',
                'group_id' => 15
            ],
            [
                'code_material' => '344001',
                'description' => '34400 - PRODUCTOS DE CUERO Y CAUCHO (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1048',
                'type' => 'Caja Chica',
                'group_id' => 16
            ],
            [
                'code_material' => '345001',
                'description' => '34500 - PRODUCTOS DE MINERALES NO METÁLICOS Y PLÁSTICOS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1049',
                'type' => 'Caja Chica',
                'group_id' => 17
            ],
            [
                'code_material' => '346001',
                'description' => '34600 - MINERALES (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1050',
                'type' => 'Caja Chica',
                'group_id' => 18
            ],
            [
                'code_material' => '348001',
                'description' => '34800 - HERRAMIENTAS MENORES (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1051',
                'type' => 'Caja Chica',
                'group_id' => 19
            ],
            [
                'code_material' => '349001',
                'description' => '34900 - MATERIAL Y EQUIPO MILITAR (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1052',
                'type' => 'Caja Chica',
                'group_id' => 20
            ],
            [
                'code_material' => '391001',
                'description' => '39100 - MATERIAL DE LIMPIEZA E HIGIENE (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1053',
                'type' => 'Caja Chica',
                'group_id' => 21
            ],
            [
                'code_material' => '392001',
                'description' => '39200 - MATERIAL DEPORTIVO Y RECREATIVO (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1054',
                'type' => 'Caja Chica',
                'group_id' => 22
            ],
            [
                'code_material' => '393001',
                'description' => '39300 - UTENSILIOS DE COCINA Y COMEDOR (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1055',
                'type' => 'Caja Chica',
                'group_id' => 23
            ],
            [
                'code_material' => '394001',
                'description' => '39400 - INSTRUMENTAL MENOR MÉDICO-QUIRÚRGICO (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1056',
                'type' => 'Caja Chica',
                'group_id' => 24
            ],
            [
                'code_material' => '395001',
                'description' => '39500 - ÚTILES DE ESCRITORIO Y OFICINA (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1057',
                'type' => 'Caja Chica',
                'group_id' => 25
            ],
            [
                'code_material' => '396001',
                'description' => '39600 - ÚTILES EDUCACIONALES, CULTURALES Y DE CAPACITACIÓN (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1058',
                'type' => 'Caja Chica',
                'group_id' => 26
            ],
            [
                'code_material' => '397001',
                'description' => '39700 - ÚTILES Y MATERIALES ELÉCTRICOS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1059',
                'type' => 'Caja Chica',
                'group_id' => 27
            ],
            [
                'code_material' => '398001',
                'description' => '39800 - OTROS REPUESTOS Y ACCESORIOS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1060',
                'type' => 'Caja Chica',
                'group_id' => 28
            ],
            [
                'code_material' => '399001',
                'description' => '39900 - OTROS MATERIALES Y SUMINISTROS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1061',
                'type' => 'Caja Chica',
                'group_id' => 29
            ],
            [
                'code_material' => '399101',
                'description' => '39910 - ACUÑACIÓN DE MONEDAS E IMPRESIÓN DE BILLETES (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1062',
                'type' => 'Caja Chica',
                'group_id' => 30
            ],
            [
                'code_material' => '399901',
                'description' => '39990 - OTROS MATERIALES Y SUMINISTROS (CAJA CHICA)',
                'unit_material' => 'GLOBAL',
                'state' => 'Inhabilitado',
                'stock' => 0,
                'min' => 5,
                'barcode' => '1063',
                'type' => 'Caja Chica',
                'group_id' => 31
            ]

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
