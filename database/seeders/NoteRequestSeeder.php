<?php

namespace Database\Seeders;

use App\Models\NoteRequest;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NoteRequestSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        NoteRequest::factory()->count(rand(5, 10))->create();
    }
}
