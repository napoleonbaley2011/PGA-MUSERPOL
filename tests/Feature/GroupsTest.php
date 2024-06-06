<?php

use App\Models\Group;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\AuthenticationHelper;

//Se realizo las pruebas correspondientes para el CRUD de Groups;
//Primero se tiene que tener todos los factories bien proesados para manejar los datos en las pruebas
//Se utiliza en Helpers para Autentificar un usuario "x" para realizar las pruebas correspondientes y entrar a las rutas restringidas
//DatabaseTransactions para que los datos creados para la prueba, se eliminen al terminar
//Prueba List, Register, Show, Update, Delete  

uses(AuthenticationHelper::class, DatabaseTransactions::class);

test('list_groups', function(){
    $user = $this->authenticateUser();
    $response = $this->get('/api/auth/groups');
    $response->assertStatus(200);
});

test('register_groups', function(){
    $this->authenticateUser();
    $data = Group::factory()->make()->toArray();
    $response = $this->postJson('/api/auth/groups', $data);

    $response->assertStatus(201)
             ->assertJson([
                'data'=>[
                    'code'=>$data['code'],
                    'name_group'=>$data['name_group'],
                    'state'=>$data['state'],
                    'classifier_id'=>$data['classifier_id'],
                ]
             ]);
    $this->assertDatabaseHas('groups',$data);
});