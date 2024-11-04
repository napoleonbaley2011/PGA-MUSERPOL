<?php

namespace Database\Seeders;

use App\Models\Note_Entrie;
use App\Models\NoteRequest;
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
            ManagementSeeder::class,
            MaterialTableSeerder::class,
            SupplierSeeder::class,
            RolStoreSeeder::class,
            UserStoreSeeder::class,
            // NoteEntrieSeeder::class,
            // NoteRequestSeeder::class,
        ]);

        //        Note_Entrie::factory()->count(300)->create();
        //        NoteRequest::factory()->count(100)->create();
    }
}
