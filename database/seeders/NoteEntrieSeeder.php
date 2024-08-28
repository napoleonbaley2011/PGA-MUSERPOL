<?php

namespace Database\Seeders;

use App\Models\Note_Entrie;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteEntrieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Note_Entrie::factory()->count(rand(5, 10))->create();
    }
}
