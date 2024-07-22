<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
       $this->call([
        //PermissionAlmacenesSeeder::class,
        ClassifierSeader::class,
        GroupTableSeeder::class,
        TypesTableSeeder::class,
        MaterialTableSeerder::class,
       ]);
    }
}
