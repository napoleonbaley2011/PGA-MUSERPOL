<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{

    public function index(Request $request)
    {
        $page = $request->get('page', 0);
        $totalSuppliers = Supplier::count();
        $limit = $request->get('limit', $totalSuppliers > 0 ? $totalSuppliers : 1);
        $start = $page * $limit;
        $search = $request->input('search', '');

        $query = Supplier::orderBy('id');

        if (!empty($search)) {
            $query->where('name', 'like', '%' . $search . '%');
        }

        $totalSuppliers = $query->count();
        $suppliers = $query->skip($start)->take($limit)->get();

        return response()->json([
            'status' => 'success',
            'total' => $totalSuppliers,
            'page' => $page,
            'last_page' => ceil($totalSuppliers / $limit),
            'suppliers' => $suppliers
        ], 200);
    }



    public function create()
    {
        //
    }


    public function store(SupplierRequest $request)
    {
        try {
            $supplier = new Supplier($request->input());

            if ($supplier->save()) {
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

    public function show(Supplier $supplier)
    {
        return response()->json(['status' => true, 'data' => $supplier], 200);
    }


    public function edit(string $id)
    {
        //
    }
    public function update(Request $request, Supplier $supplier)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'nit' => 'nullable|string|max:255',
            'cellphone' => 'string|max:20',
            'sales_representative' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $supplier->update($validatedData);

        //slogger($supplier);
        return response()->json(['data' => $supplier], 200);
    }
    public function destroy(Supplier $supplier)
    {
        $supplier->delete();
        return response()->json(['message' => 'Eliminado'], 200);
    }
}
