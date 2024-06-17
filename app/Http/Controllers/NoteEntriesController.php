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
            
    }
}
