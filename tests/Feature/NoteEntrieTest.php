<?php

use App\Models\Employee;
use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\AuthenticationHelper;

uses(AuthenticationHelper::class, DatabaseTransactions::class);

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


test('create_note', function () {
    $this->authenticateUser();
    $supplier = Supplier::factory()->create();
    //logger($supplier);
    $materials = Material::factory()->count(2)->create();
    // logger($materials);
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
    //logger($data);
    $response = $this->postJson('api/auth/createNoteEntry', $data);
    $response->assertStatus(201)
        ->assertJson([
            'number_note' => $number_note,
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
        $this->assertDatabaseHas('entries_material', [
            'material_id' => $material['id'],
            'amount_entries' => $material['quantity'],
            'cost_unit' => $material['price'],
            'cost_total' => $material['quantity'] * $material['price'],
            'name_material' => $material['name'],
        ]);
    }
});
