<?php

use App\Models\Employee;
use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\Helpers\AuthenticationHelper;

uses(AuthenticationHelper::class, RefreshDatabase::class);
//stock y habilitado agregar un sw
//anular y confrimacion doblec confirmacion
test('list_note_entries', function () {
    $this->authenticateUser();

    // Crear algunas notas de prueba
    Note_Entrie::factory()->count(5)->create();

    $response = $this->getJson('/api/notes-entries?page=0&limit=10');

    $response->assertStatus(Response::HTTP_OK)
        ->assertJsonStructure([
            'status',
            'total',
            'page',
            'last_page',
            'data' => [
                '*' => [
                    'id',
                    'number_note',
                    'invoice_number',
                    'delivery_date',
                    'state',
                    'invoice_auth',
                    'user_register',
                    'observation',
                    'type_id',
                    'suppliers_id',
                    'name_supplier',
                    'materials' => [
                        '*' => [
                            'id',
                            'amount_entries',
                            'cost_unit',
                            'cost_total',
                            'name_material'
                        ]
                    ]
                ]
            ]
        ]);
});

test('create_note', function () {
    $this->authenticateUser();

    // Crear un proveedor y algunos materiales de prueba
    $supplier = Supplier::factory()->create();
    $materials = Material::factory()->count(2)->create();

    // Datos de prueba
    $data = [
        'type' => 1,
        'id_supplier' => $supplier->id,
        'materials' => $materials->map(function ($material) {
            return [
                'id' => $material->id,
                'name' => $material->name,
                'quantity' => 10,
                'price' => 15.5,
                'unit_material' => 'kg'
            ];
        })->toArray(),
        'date_entry' => now()->toDateString(),
        'total' => 310,
        'invoice_number' => 'INV12345',
        'authorization_number' => 'AUTH12345',
        'id_user' => 'user1'
    ];

    $response = $this->postJson('/api/notes-entries', $data);

    $response->assertStatus(Response::HTTP_CREATED)
        ->assertJson([
            'number_note' => 1,
            'invoice_number' => $data['invoice_number'],
            'delivery_date' => $data['date_entry'],
            'state' => 'Creado',
            'invoice_auth' => $data['authorization_number'],
            'user_register' => $data['id_user'],
            'observation' => 'Creado recientemente',
            'type_id' => $data['type'],
            'suppliers_id' => $data['id_supplier'],
            'name_supplier' => $supplier->name,
        ]);

    foreach ($data['materials'] as $material) {
        $this->assertDatabaseHas('material_note', [
            'material_id' => $material['id'],
            'amount_entries' => $material['quantity'],
            'cost_unit' => $material['price'],
            'cost_total' => $material['quantity'] * $material['price'],
            'name_material' => $material['name'],
        ]);
    }
});

test('delete_note_entry', function () {
    $this->authenticateUser();

    // Crear una nota de prueba
    $noteEntry = Note_Entrie::factory()->create();
    $material = Material::factory()->create();
    $noteEntry->materials()->attach($material->id, [
        'amount_entries' => 5,
        'cost_unit' => 10,
        'cost_total' => 50,
        'name_material' => $material->name,
    ]);

    $response = $this->deleteJson('/api/notes-entries/' . $noteEntry->id);

    $response->assertStatus(Response::HTTP_OK)
        ->assertJson([
            'message' => 'Eliminado'
        ]);

    $this->assertDatabaseMissing('note_entries', [
        'id' => $noteEntry->id
    ]);

    $this->assertDatabaseHas('materials', [
        'id' => $material->id,
        'stock' => $material->stock
    ]);
});
