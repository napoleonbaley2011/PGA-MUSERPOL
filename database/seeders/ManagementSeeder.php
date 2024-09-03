<?php

namespace Database\Seeders;

use App\Models\Management;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ManagementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periods = [
            [
                'period_name' => '2024',
                'start_date' => '2024-01-01',
                'state' => 'Abierto',
            ]
        ];

        foreach ($periods as $periodData) {
            Management::firstOrCreate(
                ['period_name' => $periodData['period_name']],
                ['start_date' => $periodData['start_date'], 'state' => $periodData['state']]
            );
        }
    }
}
