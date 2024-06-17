<?php

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\Helpers\AuthenticationHelper;

//Se realizo las pruebas correspondientes para el CRUD de Note;
//Primero se tiene que tener todos los factories bien proesados para manejar los datos en las pruebas
//Se utiliza en Helpers para Autentificar un usuario "x" para realizar las pruebas correspondientes y entrar a las rutas restringidas
//DatabaseTransactions para que los datos creados para la prueba, se eliminen al terminar
//Prueba List, Register, Show, Update, Delete  

uses(AuthenticationHelper::class, DatabaseTransactions::class);

test('list_note_entries', function () {
    $user =$this->authenticateUser();
    $response = $this->get('/api/auth/notes');
    $response->assertStatus(200);
});
