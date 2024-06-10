<?php
use App\Models\Group;
use App\Models\Supplier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\AuthenticationHelper;

//Se realizo las pruebas correspondientes para el CRUD de Suppliers;
//Primero se tiene que tener todos los factories bien proesados para manejar los datos en las pruebas
//Se utiliza en Helpers para Autentificar un usuario "x" para realizar las pruebas correspondientes y entrar a las rutas restringidas
//DatabaseTransactions para que los datos creados para la prueba, se eliminen al terminar
//Prueba List, Register, Show, Update, Delete  

uses(AuthenticationHelper::class, DatabaseTransactions::class);

test('list_suppliers', function () {
    $this->authenticateUser();
    $response = $this->get('/api/auth/suppliers');
    $response->assertStatus(200);
});

test('register_suppliers', function(){
    $this->authenticateUser();
    $data = Supplier::factory()->make()->toArray();
    $response = $this->postJson('/api/auth/suppliers', $data);
    $response->assertStatus(201)
             ->assertJson([
                'data'=>[
                    'name'=>$data['name'],
                    'nit'=>$data['nit'],
                    'cellphone'=>$data['cellphone'],
                    'sales_representative'=>$data['sales_representative'],
                    'address'=>$data['address'],
                    'email'=>$data['email'],
                ]
             ]);
    $this->assertDatabaseHas('suppliers',$data);
});


test('show_supplier', function(){
    $this->authenticateUser();
    $supplier = Supplier::factory()->create();
    $response = $this->getJson('/api/auth/suppliers/'.$supplier->id);
    
    $response->assertStatus(200)
             ->assertJson([
                'data'=>[
                    'id'=>$supplier->id,
                    'name'=>$supplier->name,
                    'nit'=>$supplier->nit,
                    'cellphone'=>$supplier->cellphone,
                    'sales_representative'=>$supplier->sales_representative,
                    'address'=>$supplier->address,
                    'email'=>$supplier->email,
                ]
             ]);
});

test('update_supplier',function(){
    $this->authenticateUser();
    $supplier = Supplier::factory()->create();
    $updateData=[
        'name' => 'update_name',
        'nit' => 'update_nit',
        'cellphone' => 'update_cell',
        'sales_representative' => 'update_respresentative',
        'address' => 'update_address',
        'email' => 'update@update.com', 
    ];
    $response = $this->putJson('/api/auth/suppliers/'.$supplier->id, $updateData);
    $response->assertStatus(200)
             ->assertJson([
                'data'=>[
                    'name'=>$updateData['name'],
                    'nit'=>$updateData['nit'],
                    'cellphone'=>$updateData['cellphone'],
                    'sales_representative'=>$updateData['sales_representative'],
                    'address'=>$updateData['address'],
                    'email'=>$updateData['email']
                ]
             ]);
    $this->assertDatabaseHas('suppliers',array_merge(['id'=>$supplier->id]));
    
});

test('delete_supplier', function(){
    $this->authenticateUser();
    $supplier=Supplier::factory()->create();
    $response = $this->deleteJson('/api/auth/suppliers/'.$supplier->id);
    $response->assertStatus(200)
             ->assertJson([
                'message'=>'Eliminado'
             ]);
    $this->assertDatabaseMissing('suppliers',['id'=>$supplier->id]);
});