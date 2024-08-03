<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthForm;
use App\Helpers\Ldap;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Employee;
use App\Models\UserAction;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Http\Requests\Auth\AuthRequest;
use Psy\CodeCleaner\ReturnTypePass;

class AuthController extends Controller
{
    /**
     * Get a JWT via given credentials.
     *
     * Login, return a JsonWebToken to request as "Bearer" Authorization header
     *
     * @return \Illuminate\Http\JsonResponse
     */

    public function show()
    {
        return response()->json(auth('api')->user());
    }

    public function destroy()
    {
        auth('api')->logout();
        return response()->json([
            'message' => 'Logged out successfully',
        ], 201);
    }

    public function login(AuthForm $request)
    {
        $user = User::whereUsername($request['username'])->first();
        if ($user) {
            if (!$user->active) {
                return response()->json([
                    'message' => 'No autorizado',
                    'errors' => [
                        'type' => ['Usuario desactivado'],
                    ],
                ], 401);
            }
        } else {
            return response()->json([
                'message' => 'No autorizado',
                'errors' => [
                    'type' => ['Usuario no encontrado'],
                ],
            ], 401);
        }

        if (!env("LDAP_AUTHENTICATION")) {
            if ($user && Hash::check($request['password'], $user->password)) {
                return $this->respondWithToken($user->createToken('api')->plainTextToken, $user);
            } else {
                return response()->json([
                    'message' => 'No autorizado',
                    'errors' => [
                        'type' => ['Contraseña incorrecta']
                    ]
                ], 401);
            }
        } else {
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
                        $ldap->unbind();
                        return $this->respondWithToken($token, $user);
                    } else {
                        $employee = Employee::find($ldap->get_entry($request['username'], 'uid')['employeeNumber']);
                        if ($employee) {
                            $employee->username = $request['username'];
                            $employee->save();
                        } else {
                            return response()->json([
                                'message' => 'No autorizado',
                                'errors' => [
                                    'type' => ['Empleado no encontrado'],
                                ],
                            ], 401);
                        }
                        $user = new User(['username' => $request['username']]);
                        $user->save();
                        $token = $user->createToken('api')->plainTextToken;
                        $ldap->unbind();
                        return $this->respondWithToken($token, $employee);
                    }
                } else {
                    return response()->json([
                        'message' => 'No autorizado',
                        'errors' => [
                            'type' => ['Usuario o contraseña incorrectos'],
                        ],
                    ], 401);
                }
            } else {
                return response()->json([
                    'message' => 'No se pudo conectar con el servidor LDAP',
                    'errors' => [
                        'type' => ['Error de conexión'],
                    ],
                ], 500);
            }
        }
    }

    protected function respondWithToken($token, $user = null, $employee = null)
    {
        $consultant = null;
        if ($employee == null) {
            $id = $user->employee_id;
            $username = $user->username;
            $role = $user->roles[0]->name;
            $permissions = array_unique(array_merge($user->roles[0]->permissions->pluck('name')->toArray(), $user->permissions->pluck('name')->toArray()));
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


    public function guard()
    {
        return Auth::Guard('api');
    }

    public function index()
    {
        //return User::with('role')->where('id',10)->get()->first();
    }
}
