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

        $total = $suppliers->count();

        return response()->json([
            'status'=>"success",
            'total'=>$total,
            'suppliers'=>$suppliers
        ],200);
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
        try {
            $supplier = new Supplier($request->input());
    
            if($supplier->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Proveedor Creado con Exito',
                    'data' => $supplier
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Sin Exito'
                ], 403);
            }
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error: ' . $e->getMessage()
            ], 500);
        }
    
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
    public function update(Request $request, Supplier $supplier)
    {   
        //logger($supplier->id);
        logger($request->all());
        //logger($request->getContent());
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'nit' => 'nullable|string|max:255',
            'cellphone' => 'string|max:20',
            'sales_representative' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);
        
        $supplier->update($validatedData);

        logger($supplier);
        return response()->json(['data' => $supplier], 200);

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
