<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NoteRequest;
use App\Models\UserStore;
use App\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
        $noteRequests = NoteRequest::with(['employee', 'materials'])
            ->where('user_register', $userId)
            ->get();
        $result = $noteRequests->map(function ($noteRequest) {
            $name_employee = $noteRequest->employee->fullname;

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



    public function list_users_print($userId)
    {
        $name_employee = '';
        $noteRequests = NoteRequest::with(['employee', 'materials'])
            ->where('user_register', $userId)
            ->get();
        $result = $noteRequests->map(function ($noteRequest) use (&$name_employee) {
            $name_employee = $noteRequest->employee->fullname;

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

        $data = [
            'title' => 'SALIDAS POR FUNCIONARIO',
            'employee' => $name_employee,
            'date' => Carbon::now()->format('Y'),
            'result' => $result,
        ];
        $pdf = Pdf::loadView('Request_Employee.RequestEmployee', $data);
        return $pdf->download('Salidas_por_funcionario.pdf');
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



    public function list_users_direction($id_direction)
    {
        logger($id_direction);

        if ($id_direction == 1) {
            //Direccion de Estrategias Sociales e Inversiones
            $name = "Dirección de Estrategias Sociales e Inversiones";
            $array = [7, 8, 9];
        }
        if ($id_direction == 2) {
            //Direccion de Beneficios Economicos
            $name = "Dirección de Beneficios Económicos";
            $array = [11, 12, 13];
        }
        if ($id_direction == 3) {
            //Direccion de Asuntos Administrativos
            $name = "Dirección de Asuntos Administrativos";
            $array = [14, 15, 16, 17, 18];
        }
        if ($id_direction == 4) {
            //Direccion de Asesoriamiento juridico adm y defensa inter
            $name = "Dirección de Asesoramiento jurídico administrativo y defensa interinstitucional";
            $array = [19, 20, 21];
        }

        logger($array);
        $employeeIds = DB::table('public.contracts')
            ->join('public.positions', 'public.contracts.position_id', '=', 'public.positions.id')
            ->join('public.employees', 'public.contracts.employee_id', '=', 'public.employees.id')
            ->join('public.position_groups', 'public.positions.position_group_id', '=', 'public.position_groups.id')
            ->where('public.contracts.active', true)
            ->whereNull('public.contracts.deleted_at')
            ->whereIn('public.position_groups.id', $array)
            ->pluck('public.contracts.employee_id')
            ->toArray();

        $consultantEmployeeIds = DB::table('public.consultant_contracts')
            ->join('public.consultant_positions', 'public.consultant_contracts.consultant_position_id', '=', 'public.consultant_positions.id')
            ->join('public.employees', 'public.consultant_contracts.employee_id', '=', 'public.employees.id')
            ->join('public.position_groups', 'public.consultant_positions.position_group_id', '=', 'public.position_groups.id')
            ->where('public.consultant_contracts.active', true)
            ->whereNull('public.consultant_contracts.deleted_at')
            ->whereIn('public.position_groups.id', $array)
            ->pluck('public.consultant_contracts.employee_id')
            ->toArray();

        $allEmployeeIds = array_merge($employeeIds, $consultantEmployeeIds);

        $materials = NoteRequest::with('materials')
            ->whereIn('user_register', $allEmployeeIds)
            ->whereNull('deleted_at')
            ->get()
            ->flatMap(function ($noteRequest) {
                return $noteRequest->materials->map(function ($material) {
                    return [
                        'material_id' => $material->id,
                        'name' => $material->pivot->name_material,
                        'unit_material' => $material->unit_material,
                        'amount_requested' => $material->pivot->amount_request,
                    ];
                });
            })
            ->groupBy('material_id')
            ->map(function ($groupedMaterials) {
                $totalAmount = $groupedMaterials->sum('amount_requested');
                return [
                    'material_name' => $groupedMaterials->first()['name'],
                    'unit_material' => $groupedMaterials->first()['unit_material'],
                    'total_amount_requested' => $totalAmount,
                ];
            })
            ->values();

        return response()->json([
            'name' => $name,
            'materials' => $materials
        ]);
    }
}
