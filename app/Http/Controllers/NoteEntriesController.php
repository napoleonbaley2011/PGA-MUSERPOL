<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Entrie_Material;
use App\Models\Material;
use App\Models\Note_Entrie;
use App\Models\Supplier;
use Illuminate\Http\Request;

class NoteEntriesController extends Controller
{
    public function list_note_entries(Request $request)
    {
        logger($request);
        $page = max(0, $request->get('page', 0));
        $limit = max(1, $request->get('limit', Note_Entrie::count()));
        $start = $page * $limit;

        $startDate = $request->input('start_date', '');
        $endDate = $request->input('end_date', '');

        $query = Note_Entrie::with(['materials' => function ($query) {
            $query->withPivot('amount_entries', 'cost_unit', 'cost_total')->withTrashed();
        }, 'supplier'])->orderByDesc('id');

        if ($startDate && $endDate) {
            $query->whereBetween('delivery_date', [$startDate, $endDate]);
        } elseif ($startDate) {
            $query->whereDate('delivery_date', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('delivery_date', '<=', $endDate);
        }

        $totalNotes = $query->count();

        $notes = $query->skip($start)->take($limit)->get();

        return response()->json([
            'status' => 'success',
            'total' => $totalNotes,
            'page' => $page,
            'last_page' => ceil($totalNotes / $limit),
            'data' => $notes,
        ], 200);
    }

    public function create_note(Request $request)
    {
        //logger($request);

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

        $supplier_note = Supplier::find($request['id_supplier']);


        $number_note = Note_Entrie::count() + 1;
        //logger($number_note);

        //logger($validateData);

        $noteEntrie = Note_Entrie::create([
            'number_note' => $number_note,
            'invoice_number' => $validateData['invoice_number'],
            'delivery_date' => $validateData['date_entry'],
            'state' => 'Creado',
            'invoice_auth' => $validateData['authorization_number'],
            'user_register' => $validateData['id_user'],
            'observation' => 'Creado recientemente',
            'type_id' => $validateData['type'],
            'suppliers_id' => $validateData['id_supplier'],
            'name_supplier' => $supplier_note->name,
        ]);


        foreach ($validateData['materials'] as $materialData) {

            $material = Material::find($materialData['id']);
            $material->stock += $materialData['quantity'];
            $material->save();

            $noteEntrie->materials()->attach($materialData['id'], [
                'amount_entries' => $materialData['quantity'],
                'request' => $materialData['quantity'],
                'cost_unit' => $materialData['price'],
                'cost_total' => $materialData['quantity'] * $materialData['price'],
                'name_material' => $materialData['name'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        return response()->json($noteEntrie->load('materials'), 201);
    }


    public function destroy(Note_Entrie $note_entry)
    {
        $note_entry->state = "Eliminado";
        $note_entry->observation = "Eliminado";
        $note_entry->save();

        $materials = $note_entry->materials;
        foreach ($materials as $material) {
            $material->stock -= $material->pivot->request;
            $material->save();

            $entryMaterial = Entrie_Material::where('note_id', $note_entry->id)->where('material_id', $material->id)->first();

            if ($entryMaterial) {
                $entryMaterial->delete();
            }
        }
        $note_entry->delete();
        return response()->json(['message' => 'Eliminado'], 200);
    }
}
