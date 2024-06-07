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


test('show_classifier', function(){
    $this->authenticateUser();
    $group = Group::factory()->create();
    $response = $this->getJson('/api/auth/groups/'.$group->id);

    $response->assertStatus(200)
             ->assertJson([
                'data'=>[
                    'id'=>$group->id,
                    'code'=>$group->code,
                    'name_group'=>$group->name_group,
                    'state'=>$group->state,
                    'classifier_id'=>$group->classifier_id
                ]
             ]);
});

test('update_groups',function(){
    $this->authenticateUser();
    $group = Group::factory()->create();
    $updateData = [
        'code'=>'update_code',
        'name_group'=>'update_name_group',
        'state'=>"1"
    ];
    $response = $this->putJson('/api/auth/groups/'.$group->id, $updateData);
    $response->assertStatus(200)
             ->assertJson([
                'data'=>[
                    'code'=>$updateData['code'],
                    'name_group'=>$updateData['name_group'],
                    'state'=>$updateData['state']
                ]
             ]);
    $this->assertDatabaseHas('groups',array_merge(['id'=>$group->id]));


});

test('delete_group', function(){
    $this->authenticateUser();
    $groups=Group::factory()->create();
    $response = $this->deleteJson('/api/auth/groups/'.$groups->id);
    $response->assertStatus(200)
             ->assertJson([
                'message'=>'Eliminado'
             ]);
    $this->assertDatabaseMissing('classifiers',['id'=>$groups->id]);
});