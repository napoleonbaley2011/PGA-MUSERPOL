<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\NoteRequest;
use Illuminate\Http\Request;

class NoteRequestController extends Controller
{
    public function list_note_request(Request $request)
    {
        $page = $request->get('page', -1);
        $limit = $request->get('limit', NoteRequest::count());
        $start = $page * $limit;

        $state = $request->input('state', '');

        $query = NoteRequest::with(['materials', 'employee'])->orderByDesc('number_note');


        if ($state) {
            $query->where('state', $state);
        }

        $totalNoteRequests = $query->count();

        $noteRequests = $query->skip($start)->take($limit)->get();

        //logger($noteRequests);

        if ($noteRequests->isEmpty()) {
            return response()->json(['message' => 'No note requests found'], 404);
        }

        $response = $noteRequests->map(function ($noteRequest) {
            return [
                'id_note'=>$noteRequest->id,
                'number_note' => $noteRequest->number_note,
                'state' => $noteRequest->state,
                'request_date' => $noteRequest->request_date,
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
}
