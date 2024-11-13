<?php

use App\Models\Employee;
use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\AuthenticationHelper;

uses(AuthenticationHelper::class, DatabaseTransactions::class);

// Prueba para listar notas
test('list_note_entries', function () {
    $this->authenticateUser();
    $response = $this->getJson('/api/auth/notes');
    $response->assertStatus(200)
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
                    'created_at',
                    'updated_at',
                    'deleted_at',
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
                            'created_at',
                            'updated_at',
                            'deleted_at',
                            'pivot' => [
                                'note_id',
                                'material_id',
                                'amount_entries',
                                'cost_unit',
                                'cost_total',
                                'name_material',
                                'request',
                                'created_at',
                                'updated_at'
                            ]
                        ]
                    ],
                    'supplier' => [
                        'id',
                        'name',
                        'nit',
                        'cellphone',
                        'sales_representative',
                        'address',
                        'email',
                        'created_at',
                        'updated_at',
                        'deleted_at'
                    ]
                ]
            ]
        ]);
});

// Prueba para crear una nota
test('create_note', function () {
    $this->authenticateUser();
    $supplier = Supplier::factory()->create();
    $materials = Material::factory()->count(2)->create();
    $number_note = Note_Entrie::count() + 1;
    $data = [
        'type' => 1,
        'id_supplier' => $supplier->id,
        'materials' => $materials->map(function ($material) {
            return [
                'id' => $material->id,
                'name' => $material->description,
                'quantity' => 10,
                'price' => 15.5,
                'unit_material' => 'kg'
            ];
        })->toArray(),
        'date_entry' => now()->toDateString(),
        'total' => 310,
        'invoice_number' => 'INV12345',
        'authorization_number' => 'AUTH12345',
        'id_user' => "25"
    ];
    $response = $this->postJson('api/auth/createNoteEntry', $data);
    $response->assertStatus(201)
        ->assertJson([
            'number_note' => $number_note,
            'invoice_number' => $data['invoice_number'],
            'delivery_date' => $data['date_entry'],
            'state' => 'En Revision',
            'invoice_auth' => $data['authorization_number'],
            'user_register' => $data['id_user'],
            'observation' => 'Activo',
            'type_id' => $data['type'],
            'suppliers_id' => $data['id_supplier'],
            'name_supplier' => $supplier->name,
        ]);

    foreach ($data['materials'] as $material) {
        $this->assertDatabaseHas('entries_material', [
            'material_id' => $material['id'],
            'amount_entries' => $material['quantity'],
            'cost_unit' => $material['price'],
            'cost_total' => $material['quantity'] * $material['price'],
            'name_material' => $material['name'],
        ]);
    }
});

// Prueba para listar notas en revisión
test('list_note_entries_revision', function () {
    $this->authenticateUser();
    $response = $this->getJson('/api/auth/notesRevision');
    $response->assertStatus(200)
        ->assertJsonStructure([
            'status',
            'total',
            'data' => [
                '*' => [
                    'id',
                    'number_note',
                    'state',
                    'delivery_date',
                    // otros campos relevantes
                ]
            ]
        ]);
});

// Prueba para aprobar una nota
// test('approve_note_entry', function () {
//     $this->authenticateUser();
//     $note = Note_Entrie::factory()->create(['state' => 'En Revision']);
//     $materials = Material::factory()->count(2)->create();

//     $materialsData = $materials->map(function ($material) {
//         return [
//             'id_material' => $material->id,
//             'amount_entries' => 10,
//             'cost_unit' => 15.5,
//         ];
//     })->toArray();

//     $data = [
//         'noteEntryId' => $note->id,
//         'materials' => $materialsData,
//     ];

//     $response = $this->postJson('/api/auth/approvedNoteEntry', $data);
//     $response->assertStatus(201)
//         ->assertJson([
//             'state' => 'Aceptado',
//         ]);

//     foreach ($materialsData as $material) {
//         $this->assertDatabaseHas('materials', [
//             'id' => $material['id_material'],
//             'stock' => 10,
//         ]);
//     }
// });
test('approve_note_entry', function () {
    $this->authenticateUser();
    $note = Note_Entrie::factory()->create(['state' => 'En Revision']);
    $materials = Material::factory()->count(2)->create();

    $materialsData = $materials->map(function ($material) {
        return [
            'id_material' => $material->id,
            'amount_entries' => 10, // cantidad que se agrega al stock actual
            'cost_unit' => 15.5,
        ];
    })->toArray();

    // Obtenemos los valores de stock iniciales para comparar luego
    $initialStocks = $materials->pluck('stock', 'id');

    $data = [
        'noteEntryId' => $note->id,
        'materials' => $materialsData,
    ];

    $response = $this->postJson('/api/auth/approvedNoteEntry', $data);
    $response->assertStatus(201)
        ->assertJson([
            'state' => 'Aceptado',
        ]);

    // Comprobar que el stock se haya incrementado correctamente en lugar de ser exactamente igual a 10
    foreach ($materialsData as $material) {
        $expectedStock = $initialStocks[$material['id_material']] + $material['amount_entries'];
        $this->assertDatabaseHas('materials', [
            'id' => $material['id_material'],
            'stock' => $expectedStock,
        ]);
    }
});

// Prueba para eliminar una nota
test('delete_note_entry', function () {
    $this->authenticateUser();
    $note = Note_Entrie::factory()->create(['state' => 'En Revision']);

    $response = $this->deleteJson("/api/auth/deleteNoteEntry/{$note->id}");

    $response->assertStatus(200)
        ->assertJson(['message' => 'Eliminado']);

    $this->assertDatabaseHas('note_entries', [
        'id' => $note->id,
        'state' => 'Eliminado',
        'observation' => 'Eliminado',
    ]);
});

// Prueba para obtener una nota en PDF
test('print_note_entry', function () {
    $this->authenticateUser();
    $note = Note_Entrie::factory()->create();
    $material = Material::factory()->create();
    $note->materials()->attach($material->id, [
        'amount_entries' => 10,
        'cost_unit' => 15.5,
        'cost_total' => 155,
    ]);

    $response = $this->get("/api/auth/printNoteEntry/{$note->id}");
    $response->assertStatus(200)
        ->assertHeader('Content-Type', 'application/pdf');
});
