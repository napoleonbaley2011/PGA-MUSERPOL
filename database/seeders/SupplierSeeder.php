<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $Suppliers = [
            [
                'name' => 'SAN MARTIN',
                'nit' => '123123123',
                'cellphone' => '63217504',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Arce',
                'email' => 'leonellima56@gmail.com',
            ],
            [
                'name' => 'SAN LUIS',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'TURPEX SRL',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'DISTRIBUIDORA D&M',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'SOPCON S.R.L.',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'DECOSUR DECORACIONES LIMITADA',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'LOGI COMPUTER STORE',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'ALZARCOR SERVICIOS GENERALES',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'FERRETERIA RUDY',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'E.S CINCO ESQUINAS',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'TROFEOS MUNDIAL',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'FERRETERIA PINTURAS MATERIAL ELECTRICO PLOMERIA',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'DISTRIBUIDORA VIRGEN DEL ROSARIO',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'MULTISUMINISTROS',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],
            [
                'name' => 'SUPERMERCADO LA FAMILIA S.R.L.',
                'nit' => '1231231213',
                'cellphone' => '63217505',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Roma',
                'email' => 'leonellima55@gmail.com',
            ],

        ];

        foreach ($Suppliers as $supplierData) {
            Supplier::firstOrCreate(
                ['name' => $supplierData['name']],
                ['nit' => $supplierData['nit'], 'cellphone' => $supplierData['cellphone'], 'sales_representative' => $supplierData['sales_representative'], 'address' => $supplierData['address'], 'email' => $supplierData['email']]
            );
        }
    }
}
