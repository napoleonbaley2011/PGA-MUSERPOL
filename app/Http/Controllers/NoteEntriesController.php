<?php

namespace App\Http\Controllers;

use App\Models\Note_Entrie;
use App\Models\Supplier;
use Illuminate\Http\Request;

class NoteEntriesController extends Controller
{
    public function list_note_entries(){
        $notes = Note_Entrie::all();
        return response()->json([
            'data'=>$notes,
        ],200);

    }

    public function create_note(Request $request){
        // logger($request);

        $validateData = $request->validate([
            'type' => 'required|integer',
            'id_supplier' => 'requered|integer',
            'materials' => 'required|array',
            'materials.*.id' => 'required|exists:materials,id',
            'materials.*.name' => 'required|string',
            'materials.*.quantity' => 'required|integer',
            'materials.*.price' => 'required|numeric',
            'materials.*.unit_material' => 'required|string',
            'date_entry' => 'required|date',
            'total' => 'required|numeric',
            'invoice_number' => 'required|string',
            'authorization_number' => 'required|string',
            'id_supplier' => 'required|exists:suppliers,id',
            'id_user' => 'required|string'
        ]);

        $number_note = Note_Entrie::count() + 1;
        //logger($number_note);

        //logger($validateData);

        $noteEntrie = Note_Entrie::create([
            'number_note'=>$number_note,
            'invoice_number'=>$validateData['invoice_number'],
            'delivery_date' =>$validateData['date_entry'],
            'state' => 'Creado',
            'invoice_auth' => $validateData['authorization_number'],
            'user_register' => $validateData['id_user'],
            'observation' => 'Creado recientemente',
            'type_id' => $validateData['type'],
            'suppliers_id' => $validateData['id_supplier'],
        ]);


        foreach ($validateData['materials'] as $materialData){
            $noteEntrie->materials()->attach($materialData['id'],[
                'amount_entries' => $materialData['quantity'],
                'cost_unit' => $materialData['price'],
                'cost_total' => $materialData['quantity'] * $materialData['price'],
            ]);
        }

        return response()->json($noteEntrie->load('materials'), 201);

    }
}
