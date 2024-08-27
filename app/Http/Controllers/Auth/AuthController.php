<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthForm;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Models\Employee;
use App\Helpers\Ldap;

class AuthController extends Controller
{
    /**
     * Método de autenticación principal
     */
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
            return $this->handleDatabaseAuthentication($request, $user);
        } else {
            return $this->handleLdapAuthentication($request);
        }
    }

    private function handleDatabaseAuthentication($request, $user)
    {
        if (Hash::check($request['password'], $user->password)) {
            return $this->respondWithToken($user->createToken('api')->plainTextToken, $user);
        } else {
            return $this->unauthorizedResponse('Contraseña incorrecta');
        }
    }

    private function handleLdapAuthentication($request)
    {
        $ldap = new Ldap();

        if ($ldap->connection && $ldap->verify_open_port()) {
            if ($ldap->bind($request['username'], $request['password'])) {
                $user = User::where('username', $request['username'])->where('active', true)->first();
                if ($user) {
                    if (!Hash::check($request['password'], $user->password)) {
                        $user->password = Hash::make($request['password']);
                        $user->save();
                    }
                    $token = $user->createToken('api')->plainTextToken;

                    return $this->respondWithToken($token, $user);
                } else {
                    return $this->unauthorizedResponse('Usuario o contraseña incorrectos');
                }
            } else {
                return $this->unauthorizedResponse('Usuario o contraseña incorrectos');
            }
        } else {
            return $this->serverErrorResponse('No se pudo conectar con el servidor LDAP');
        }
    }

    protected function respondWithToken($token, $user)
    {
        $id = $user->employee_id;
        $username = $user->username;
        $role = $user->roles[0]->name;
        $permissions = array_unique(array_merge(
            $user->roles[0]->permissions->pluck('name')->toArray(),
            $user->permissions->pluck('name')->toArray()
        ));
        return response()->json([
            'token' => $token,
            'token_type' => 'Bearer',
            'expires_in' => config('sanctum.expiration') ? now()->addMinutes(config('sanctum.expiration'))->timestamp : null,
            'id' => $id,
            'user' => $username,
            'role' => $role,
            'permissions' => $permissions,
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

    /**
     * Respuesta de error de servidor
     */
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
