<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = Supplier::all();
        return response()->json(['data'=>$suppliers],200);
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
    public function store(SupplierRequest $request)
    {   
        $supplier = new Supplier($request->input());
        $supplier -> save();
        return response()->json([
            'status'=>true,
            'message'=> 'Proveedor Creado con Exito',
            'data'=>$supplier
        ],201);
    
    }

    /**
     * Display the specified resource.
     */
    public function show(Supplier $supplier)
    {
        return response()->json(['status'=> true, 'data'=>$supplier],200);
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
    public function update(SupplierRequest $request, Supplier $supplier)
    {   
        $update_supplier = Supplier::findOrFail($supplier->id);
        $update_supplier->update($request->all());
        return response()->json(['data' => $update_supplier],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(['message'=>'Eliminado'],200);
    }
}
