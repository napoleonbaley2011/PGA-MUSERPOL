<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Entrie_Material;
use App\Models\Entry;
use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\NoteRequest;
use App\Models\Request_Material;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class NoteRequestController extends Controller
{
    public function list_note_request(Request $request)
    {
        //logger($request);
        $page = $request->get('page', 0);
        $limit = $request->get('limit', NoteRequest::count());
        $start = $page * $limit;
        $state = $request->input('state', '');


        $query = NoteRequest::with(['materials', 'employee'])->orderByDesc('number_note');

        if ($state) {
            $query->where('state', $state);
        }

        $totalNoteRequests = $query->count();

        $noteRequests = $query->skip($start)->take($limit)->get();

        if ($noteRequests->isEmpty()) {
            return response()->json(['message' => 'No note requests found'], 404);
        }

        $response = $noteRequests->map(function ($noteRequest) {
            return [
                'id_note' => $noteRequest->id,
                'number_note' => $noteRequest->number_note,
                'state' => $noteRequest->state,
                'request_date' => $noteRequest->request_date,
                'observation' => $noteRequest->observation,
                'employee' => $noteRequest->employee
                    ? "{$noteRequest->employee->first_name} {$noteRequest->employee->last_name} {$noteRequest->employee->mothers_last_name}"
                    : null,
                'materials' => $noteRequest->materials->map(function ($material) {
                    return [
                        'id' => $material->id,
                        'code_material' => $material->code_material,
                        'description' => $material->description,
                        'unit_material' => $material->unit_material,
                        'stock' => $material->stock,
                        'amount_request' => $material->pivot->amount_request,
                        'delivered_quantity' => $material->pivot->delivered_quantity,
                        'name_material' => $material->pivot->name_material,
                    ];
                }),
            ];
        });



        return response()->json([
            'status' => 'success',
            'total' => $totalNoteRequests,
            'page' => $page,
            'last_page' => ceil($totalNoteRequests / $limit),
            'data' => $response,
        ], 200);
    }
    public function listUserNoteRequests($userId)
    {
        $noteRequests = NoteRequest::where('user_register', $userId)->with('materials')->get();

        if ($noteRequests->isEmpty()) {
            return response()->json(['message' => 'No note requests found for this user'], 404);
        }
        $response = $noteRequests->map(function ($noteRequest) {
            return [
                'id' => $noteRequest->id,
                'number_note' => $noteRequest->number_note,
                'state' => $noteRequest->state,
                'request_date' => $noteRequest->request_date,
                'materials' => $noteRequest->materials->map(function ($material) {
                    return [
                        'code_material' => $material->code_material,
                        'description' => $material->description,
                        'amount_request' => $material->pivot->amount_request,
                        'delivered_quantity' => $material->pivot->delivered_quantity,
                        'name_material' => $material->pivot->name_material,
                    ];
                }),
            ];
        });

        // logger($response);

        return response()->json($response);
    }

    public function create_note_request(Request $request)
    {
        $number_note = NoteRequest::count() + 1;

        $noteRequest = NoteRequest::create([
            'number_note' => $number_note,
            'state' => 'En Revision',
            'observation' => 'Ninguno',
            'user_register' => $request['id'],
            'request_date' => today()->toDateString()
        ]);
        // logger($noteRequest);

        foreach ($request['material_request'] as $materialData) {
            $noteRequest->materials()->attach($materialData['id'], [
                'amount_request' => $materialData['quantity'],
                'name_material' => $materialData['description']
            ]);
        }
        return response()->json($noteRequest->load('materials'), 201);
    }


    public function delivered_of_material(Request $request)
    {
        //logger($request);
        if ($request->status == "Approved") {
            $materials_validate = $request->input('materials');

            foreach ($materials_validate as $material) {
                $material_stock = Material::find($material['id_material']);

                if ($material_stock->stock < $material['amount_to_deliver']) {
                    return response()->json(['status' => false, 'message' => 'No hay suficiente stock en almacenes'], 404);
                }
            }
            $noteRequestId = $request->input('noteRequestId');
            $materialsToDeliver = $request->input('materials');

            foreach ($materialsToDeliver as $material) {
                $materialId = $material['id_material'];
                $amountToDeliver = (int) $material['amount_to_deliver'];
                $amount_to_be_reduced = $amountToDeliver;
                $entries = Note_Entrie::whereHas('materials', function ($query) use ($materialId) {
                    $query->where('materials.id', $materialId);
                })
                    ->where('state', '!=', 'Eliminado')
                    ->orderBy('created_at', 'asc')
                    ->get();

                //logger($entries);

                foreach ($entries as $entry) {
                    $entryMaterialPivot = $entry->materials()->where('materials.id', $materialId)->first()->pivot;
                    $availableAmount = $entryMaterialPivot->request;
                    if ($availableAmount >= $amountToDeliver) {
                        $entryMaterialPivot->request -= $amountToDeliver;
                        $entryMaterialPivot->save();
                        break;
                    } else {
                        $amountToDeliver -= $availableAmount;
                        $entryMaterialPivot->request = 0;
                        $entryMaterialPivot->save();
                    }
                }
                $requestMaterial = Request_Material::where('note_id', $noteRequestId)
                    ->where('material_id', $materialId)
                    ->first();
                //logger($amountToDeliver);
                $requestMaterial->delivered_quantity = $amount_to_be_reduced;
                $requestMaterial->save();


                //logger($amountToDeliver);
                $material = Material::find($materialId);
                $material->stock -= $amount_to_be_reduced;

                $material->save();
                //logger($material);
            }

            $noteRequest = NoteRequest::find($noteRequestId);
            $noteRequest->state = 'Aceptado';
            $noteRequest->save();
            return response()->json(['status' => true, 'message' => 'Solicitud Aceptada'], 200);
        } else {

            $noteRequestId = $request->input('noteRequestId');
            $noteRequest = NoteRequest::find($noteRequestId);
            $noteRequest->observation = $request->input('cancelComment');
            $noteRequest->state = 'Cancelado';
            $noteRequest->save();
            return response()->json(['status' => true, 'message' => 'Solicitud Cancelada'], 200);
        }
    }

    public function print_request(NoteRequest $note_request)
    {
        // logger($note_request);
        $user = User::where('employee_id', $note_request->user_register)->first();

        $position = $user->position;
        $employee = Employee::find($note_request->user_register);
        $file_title = 'SOLICITUD DE MATERIAL DE ALMACÉN';
        $materials = $note_request->materials()->get()->map(function ($material) {
            return [
                'description' => $material->description,
                'unit_material' => $material->unit_material,
                'amount_request' => $material->pivot->amount_request,
            ];
        });

        $data = [
            'title' => 'SOLICITUD DE MATERIAL DE ALMACÉN',
            'number_note' => $note_request->number_note,
            'date' => Carbon::now()->format('Y'),
            'employee' => $employee
                ? "{$employee->first_name} {$employee->last_name} {$employee->mothers_last_name}"
                : null,
            'position' => $user->position,
            'materials' => $materials,
        ];
        $options = [
            'page-width' => '216',
            'page-height' => '279',
            'margin-top' => '4',
            'margin-bottom' => '4',
            'margin-left' => '5',
            'margin-right' => '5',
            'encoding' => 'UTF-8',
        ];

        $pdf = Pdf::loadView('Material_Request.MaterialRequest', $data);
        return $pdf->download('formulario_solicitud_de_material_de_almacén.pdf');
    }
}
