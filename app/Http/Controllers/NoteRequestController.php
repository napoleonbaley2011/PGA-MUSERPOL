<?php

namespace App\Http\Controllers;

use App\Models\NoteRequest;
use Illuminate\Http\Request;

class NoteRequestController extends Controller
{
    public function list_note_request()
    {
        $noteRequests = NoteRequest::with('materials')->get();
        return response()->json($noteRequests);
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
        
        $noteRequest =NoteRequest::create([
            'number_note' => $number_note,
            'state' => 'En Revision',
            'observation' => 'Ninguno',
            'user_register' => $request['id'],
            'request_date' => today()->toDateString()
        ]);
        // logger($noteRequest);

        foreach ($request['material_request'] as $materialData) {
            $noteRequest->materials()->attach($materialData['id'],[
                'amount_request' => $materialData['quantity'],
                'name_material' => $materialData['description']
            ]);
        }
        return response()->json($noteRequest->load('materials'), 201);
    }
}
