<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        $products = [
            [
                'description' => 'REFRIGERIO (SALTEÑAS)',
                'cost_object' => 'REFRIGERIO'
            ],
            [
                'description' => 'PLATILLOS',
                'cost_object' => 'UTENCILIOS'
            ],
            [
                'description' => 'REFRIGERIO (REFRESCO)',
                'cost_object' => 'REFRIGERIO'
            ],
            [
                'description' => 'PASAJES',
                'cost_object' => 'TRASNPORTE PERSONAL'
            ]

        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['description' => $product['description']],
                ['cost_object' => $product['cost_object']]
            );
        }
    }
}
