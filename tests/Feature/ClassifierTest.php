<?php

use App\Models\Classifier;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\AuthenticationHelper;

//Se realizo las pruebas correspondientes para el CRUD de Classifier;
//Primero se tiene que tener todos los factories bien proesados para manejar los datos en las pruebas
//Se utiliza en Helpers para Autentificar un usuario "x" para realizar las pruebas correspondientes y entrar a las rutas restringidas
//DatabaseTransactions para que los datos creados para la prueba, se eliminen al terminar
//Prueba List, Register, Show, Update, Delete  

uses(AuthenticationHelper::class, DatabaseTransactions::class);

test('list_classifier', function () {
    
    $user = $this->authenticateUser();

    $response = $this->get('/api/auth/classifiers');

    $response->assertStatus(200);
});

test('register_classifier', function(){
    $this->authenticateUser();
   
    $data = Classifier::factory()->make()->toArray();

    $response = $this->postJson('/api/auth/classifiers', $data);


    $response->assertStatus(201) 
             ->assertJson([
                 'data' => [
                     'code_class' => $data['code_class'],
                     'nombre' => $data['nombre'],
                     'description' => $data['description'],
                 ]
             ]);

    $this->assertDatabaseHas('classifiers', $data);
});


test('show_classifier', function(){
    $user = $this->authenticateUser();
    $classifier = Classifier::factory()->create();
    $response = $this->getJson('/api/auth/classifiers/'. $classifier->id);

    $response->assertStatus(200)
             ->assertJson([
                'data' => [
                    'id'=>$classifier->id,
                    'code_class'=>$classifier->code_class,
                    'nombre'=>$classifier->nombre,
                    'description'=>$classifier->description,
                ]
             ]);
});

test('update_classifier',function(){
    $user = $this->authenticateUser();
    $classifier = Classifier::factory()->create();
    $updateData = [
        'code_class' => 'updated_code',
        'nombre'=>'update nombre',
        'description'=>'update_description'
    ];

    $response = $this->putJson('/api/auth/classifiers/'.$classifier->id,$updateData);

    $response->assertStatus(200)
             ->assertJson([
                'data' => [
                    'code_class'=>$updateData['code_class'],
                    'nombre'=>$updateData['nombre'],
                    'description'=>$updateData['description']
                ]
             ]);
    $this->assertDatabaseHas('classifiers',array_merge(['id'=>$classifier->id]));

});

test('delete_classifier', function(){
    $this->authenticateUser();
    $classifier=Classifier::factory()->create();
    $response = $this->deleteJson('/api/auth/classifiers/'.$classifier->id);
    $response->assertStatus(200)
             ->assertJson([
                'message'=>'Eliminado'
             ]);
    $this->assertDatabaseMissing('classifiers',['id'=>$classifier->id]);
});