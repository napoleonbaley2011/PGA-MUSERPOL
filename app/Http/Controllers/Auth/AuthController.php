<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Helpers\Ldap;

class AuthController extends Controller
{
    public function login(AuthForm $request)
    {
        $user = User::whereUsername($request['username'])->first();
        if (!$user) {
            return $this->unauthorizedResponse('Usuario no encontrado');
        }

        if (!$user->active) {
            return $this->unauthorizedResponse('Usuario desactivado');
        }

        if (!env("LDAP_AUTHENTICATION")) {
            //logger("leo");
            return $this->handleDatabaseAuthentication($request, $user);
        } else {
            //logger("leo1");
            return $this->handleLdapAuthentication($request, $user);
        }
    }

    private function handleDatabaseAuthentication($request, $user)
    {
        //logger($request);
        if (Hash::check($request['password'], $user->password)) {
            return $this->respondWithToken($user->createToken('api')->plainTextToken, $user);
        } else {
            return $this->unauthorizedResponse('Contraseña incorrecta');
        }
    }

    private function handleLdapAuthentication($request, $user)
    {
        //logger($request);
        $ldap = new Ldap();
        if ($ldap->connection && $ldap->verify_open_port()) {
            if ($ldap->bind($request['username'], $request['password'])) {
                return $this->processLdapUser($request, $user, $ldap);
            } else {
                return $this->unauthorizedResponse('Usuario o contraseña incorrectos');
            }
        } else {
            return $this->serverErrorResponse('No se pudo conectar con el servidor LDAP');
        }
    }

    private function processLdapUser($request, $user, $ldap)
    {
        if ($user) {
            if (!Hash::check($request['password'], $user->password)) {
                $user->password = Hash::make($request['password']);
                $user->save();
            }
            $token = $user->createToken('api')->plainTextToken;
            $ldap->unbind();
            return $this->respondWithToken($token, $user);
        } else {
            return $this->registerLdapEmployee($request, $ldap);
        }
    }

    private function registerLdapEmployee($request, $ldap)
    {
        $employee = Employee::find($ldap->get_entry($request['username'], 'uid')['employeeNumber']);
        if ($employee) {
            $employee->username = $request['username'];
            $employee->save();
        } else {
            return $this->unauthorizedResponse('Empleado no encontrado');
        }

        $user = new User(['username' => $request['username']]);
        $user->save();
        $token = $user->createToken('api')->plainTextToken;
        $ldap->unbind();
        return $this->respondWithToken($token, null, $employee);
    }

    protected function respondWithToken($token, $user = null, $employee = null)
    {
        $consultant = null;
        if ($employee == null) {
            $id = $user->employee_id;
            $username = $user->username;
            $role = $user->roles[0]->name;
            $permissions = array_unique(array_merge(
                $user->roles[0]->permissions->pluck('name')->toArray(),
                $user->permissions->pluck('name')->toArray()
            ));
        } else {
            $id = $employee->id;
            $username = $employee->username;
            $role = 'guest';
            $permissions = [];
            $consultant = $employee->consultant();
        }

        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration') ? now()->addMinutes(config('sanctum.expiration'))->timestamp : null,
            'id' => $id,
            'user' => $username,
            'role' => $role,
            'permissions' => $permissions,
            'consultant' => $consultant,
            'message' => 'Identidad verificada',
        ], 200);
    }

    private function unauthorizedResponse($message)
    {
        return response()->json([
            'message' => 'No autorizado',
            'errors' => [
                'type' => [$message],
            ],
        ], 401);
    }

    private function serverErrorResponse($message)
    {
        return response()->json([
            'message' => $message,
            'errors' => [
                'type' => ['Error de conexión'],
            ],
        ], 500);
    }
}
