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
                'name' => 'San Martin',
                'nit' => '123123123',
                'cellphone' => '63217504',
                'sales_representative' => 'Leonel Lima',
                'address' => 'Av. Arce',
                'email' => 'leonellima56@gmail.com',
            ],
            [
                'name' => 'San Luis Librerias',
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
