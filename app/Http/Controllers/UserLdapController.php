<?php

namespace App\Http\Controllers;

use App\Models\UserStore;
use App\User;
use Illuminate\Http\Request;

class UserLdapController extends Controller
{
    public function list_users_rol()
    {
        $users = User::with(['roles.permissions', 'permissions'])
            ->where('active', '=', true)
            ->whereHas('roles', function ($query) {
                $query->whereIn('name', ['almacenes', 'admin']);
            })
            ->get();
        $userstore = UserStore::all();

        $userstoreNames = $userstore->pluck('name_user')->toArray();

        $filteredUsers = $users->filter(function ($user) use ($userstoreNames) {
            return in_array($user->username, $userstoreNames);
        });

        return response()->json($filteredUsers->map(function ($user) {
            return [
                'id' => $user->id,
                'username' => $user->username,
                'position' => $user->position,
                'roles' => $user->roles->pluck('name'),
                'all_permissions' => $user->all_permissions,
            ];
        })->values());
    }
}
