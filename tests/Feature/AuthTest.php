<?php

use App\Helpers\Ldap;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Config;
use Tests\Helpers\AuthenticationHelper;

uses(AuthenticationHelper::class, DatabaseTransactions::class);

test('can login a user via database authentication', function () {

    $response = $this->postJson('/api/auth/login', [
        'username' => 'wnavia',
        'password' => 'Sesamo123.',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'token_type',
            'expires_in',
            'id',
            'user',
            'role',
            'permissions',
            'message',
        ]);
});


test('fails login for inactive users', function () {

    $response = $this->postJson('/api/auth/login', [
        'username' => 'bquispe-',
        'password' => '123456',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'No autorizado',
            'errors' => [
                'type' => ['Usuario desactivado'],
            ],
        ]);
});

it('can login a user via LDAP authentication', function () {
    Config::set('app.ldap_authentication', true);

    $ldapMock = Mockery::mock(Ldap::class);
    $ldapMock->shouldReceive('verify_open_port')->andReturn(true);
    $ldapMock->shouldReceive('bind')->with('testuser', 'password')->andReturn(true);
    $ldapMock->shouldReceive('unbind')->andReturnNull();
    $ldapMock->shouldReceive('get_entry')->with('testuser', 'uid')->andReturn(['employeeNumber' => '12345']);

    $this->instance(Ldap::class, $ldapMock);

    $response = $this->postJson('/api/auth/login', [
        'username' => 'wnavia',
        'password' => 'Sesamo123.',
    ]);

    $response->assertStatus(200)
        ->assertJsonStructure([
            'token',
            'token_type',
            'expires_in',
            'id',
            'user',
            'role',
            'permissions',
            'message',
        ]);
});


test('fails login with wrong LDAP credentials', function () {
    Config::set('app.ldap_authentication', true);

    $ldapMock = Mockery::mock(Ldap::class);
    $ldapMock->shouldReceive('verify_open_port')->andReturn(true);
    $ldapMock->shouldReceive('bind')->with('testuser', 'wrongpassword')->andReturn(false);

    $this->instance(Ldap::class, $ldapMock);

    $response = $this->postJson('/api/auth/login', [
        'username' => 'aguisbert',
        'password' => 'wrongpassword',
    ]);

    $response->assertStatus(401)
        ->assertJson([
            'message' => 'No autorizado',
            'errors' => [
                'type' => ['Contraseña incorrecta'],
            ],
        ]);
});
