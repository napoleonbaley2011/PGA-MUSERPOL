<?php

namespace Database\Seeders;

use App\Models\Fund;
use Illuminate\Database\Seeder;

class FundSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Fund::firstOrCreate(
            ['reception_date' => '2024-12-03'], // Identificador único
            [
                'received_amount' => 15000,
                'current_amount' => 15000,
                'name_responsible' => 'WILLIAM ITURRALDE QUISBERT',
            ]
        );
    }
}
