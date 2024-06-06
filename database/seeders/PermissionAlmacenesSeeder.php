<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
class PermissionAlmacenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        $permissions = [
            [
                'name'=>'create-groups',
                'display_name'=>'Crear Grupo Materiales',
                'description'=>'Permiso para crear un nuevo grupo de materiales'
            ],
            [
                'name'=>'edit-groups',
                'display_name'=>'Editar Grupo Materiales',
                'description'=>'Permiso para crear un editar grupo de materiales'
            ],
            [
                'name'=>'delete-groups',
                'display_name'=>'Eliminar Grupo Materiales',
                'description'=>'Permiso para crear un eliminar grupo de materiales'
            ],
            [
                'name'=>'create-material',
                'display_name'=>'Crear material',
                'description'=>'Permiso para registrar un nuevo material'
            ],
            [
                'name'=>'edit-material',
                'display_name'=>'Editar material',
                'description'=>'Permiso para crear un editar materiales'
            ],
            [
                'name'=>'delete-material',
                'display_name'=>'Eliminar material',
                'description'=>'Permiso para crear un eliminar materiales'
            ],
            [
                'name'=>'create-supplier',
                'display_name'=>'Crear proveedor',
                'description'=>'Permiso para registrar un nuevo proveedor'
            ],
            [
                'name'=>'edit-supplier',
                'display_name'=>'Editar proveedor',
                'description'=>'Permiso para editar un proveedor'
            ],
            [
                'name'=>'delete-supplier',
                'display_name'=>'Eliminar proveedor',
                'description'=>'Permiso para eliminar un proveedor'
            ],
        ];

        foreach ($permissions as $permissionData){
            Permission::firstOrCreate(
                ['name' => $permissionData['name']],
                ['display_name'=>$permissionData['display_name'], 'description'=>$permissionData['description']]
            );
        }

        $role = DB::insert(
            "INSERT INTO public.permission_role (permission_id, role_id) VALUES (30, 5),(31,5),(32, 5),(33,5),(34, 5),(35,5),(36, 5),(37,5),(38,5)"
        );
    }
}
