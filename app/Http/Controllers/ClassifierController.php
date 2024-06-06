<?php

namespace App\Http\Controllers;

use App\Models\Classifier;
use Illuminate\Http\Request;

class ClassifierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classifiers = Classifier::all();
        return response()->json($classifiers);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'code_class' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'description' => 'required|string'
        ]);

        $classifier = Classifier::create($validate);

        return response()->json(['data'=>$classifier],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $classifiers = Classifier::findOrFail($id);
        return response()->json(['data'=>$classifiers],200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'code_class' => 'required|string|max:255',
            'nombre' => 'required|string|max:255',
            'description' => 'required|string',
        ]);

        $classifier = Classifier::findOrFail($id);
        $classifier->update($validated);

        return response()->json(['data'=>$classifier],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $classifier = Classifier::findOrFail($id);
        $classifier->delete();
        return response()->json(['message'=>'Eliminado'],200);
    }
}


//DB TRANSACCION
//ESTUDIAR