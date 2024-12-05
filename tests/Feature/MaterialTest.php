<?php

use App\Models\Material;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\AuthenticationHelper;

uses(AuthenticationHelper::class, DatabaseTransactions::class);

// test('create_material', function () {
//     $this->authenticateUser();
//     $data = Material::factory()->make()->toArray();
//     $response = $this->postJson('api/auth/materials', $data);
//     $response->assertStatus(201)
//         ->assertJson([
//             'data' => [
//                 'code_material' => $data['code_material'],
//                 'description' => $data['description'],
//                 'unit_material' => $data['unit_material'],
//                 'state' => $data['state'],
//                 'stock' => $data['stock'],
//                 'min' => $data['min'],
//                 'barcode' => $data['barcode'],
//                 'type' => $data['type'],
//                 'group_id' => $data['group_id'],
//             ]
//         ]);
//     $this->assertDatabaseHas('materials', $data);
// });

// test('update_name_material', function () {
//     $this->authenticateUser();
//     $material = Material::factory()->create();
//     $updateData = [
//         'description' => 'update_description',
//         'unit_material' => 'update_unit',
//     ];
//     $response = $this->patchJson('api/auth/updateName/' . $material->id, $updateData);
//     $response->assertStatus(200)
//         ->assertJson([
//             'data' => [
//                 'description' => $updateData['description'],
//                 'unit_material' => $updateData['unit_material'],
//             ]
//         ]);

//     $this->assertDatabaseHas('materials', array_merge(['id' => $material->id]));
// });

test('list_materials', function () {
    $this->authenticateUser();
    $response = $this->get('api/auth/materialslist');
    $response->assertStatus(200);
    $response->assertJsonStructure([
        'status',
        'total',
        'page',
        'last_page',
        'materials' => [
            '*' => [
                'id',
                'code_material',
                'description',
                'unit_material',
                'state',
                'stock',
                'min',
                'barcode',
                'type',
                'group_id',
            ]
        ]
    ]);
});

test('update_material', function () {
    $this->authenticateUser();
    $material = Material::factory()->create(['stock' => 10, 'state' => 'Habilitado']);
    $updateData = ['state' => 'Habilitado'];
    $response = $this->putJson('api/auth/materials/' . $material->id, $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'data' => [
                'state' => 'Inhabilitado',
            ],
        ]);

    $this->assertDatabaseHas('materials', [
        'id' => $material->id,
        'state' => 'Inhabilitado',
    ]);

    $material->update(['stock' => 0, 'state' => 'Inhabilitado']);
    $updateData = ['state' => 'Inhabilitado'];
    $response = $this->putJson('api/auth/materials/' . $material->id, $updateData);
    $response->assertStatus(400)
        ->assertJson([
            'status' => false,
            'message' => "Debe existir Stock para poder Habilitar el material",
        ]);

    $this->assertDatabaseHas('materials', [
        'id' => $material->id,
        'state' => 'Inhabilitado',
    ]);
    $material->update(['stock' => 10, 'state' => 'Inhabilitado']);
    $response = $this->putJson('api/auth/materials/' . $material->id, $updateData);

    $response->assertStatus(200)
        ->assertJson([
            'status' => true,
            'data' => [
                'state' => 'Habilitado',
            ],
        ]);
    $this->assertDatabaseHas('materials', array_merge(['id' => $material->id]));
});
