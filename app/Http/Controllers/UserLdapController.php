<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NoteRequest;
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

    public function list_users($userId)
    {
        logger($userId);
        $noteRequests = NoteRequest::with(['employee', 'materials'])
            ->where('user_register', $userId)
            ->get();
        $result = $noteRequests->map(function ($noteRequest) {
            $id_employee = $noteRequest->employee->id;
            return [
                'employee' => [
                    'id' => $noteRequest->employee->id,
                    'name' => $noteRequest->employee->fullname,
                ],
                'note_id' => $noteRequest->id,
                'materials' => $noteRequest->materials->map(function ($material) {
                    return [
                        'material_id' => $material->id,
                        'name_material' => $material->pivot->name_material,
                        'amount_requested' => $material->pivot->amount_request,
                        'delivered_quantity' => $material->pivot->delivered_quantity,
                        'unit_material' => $material->unit_material,
                    ];
                })
            ];
        });
        return response()->json($result);
    }


    public function list_user_request()
    {
        $employees = Employee::whereHas('note_requests')
            ->orderBy('last_name')
            ->get();

        $result = $employees->map(function ($employee) {
            return [
                'id' => $employee->id,
                'full_name' => $employee->fullName(),
            ];
        });

        return response()->json($result);
    }
}
