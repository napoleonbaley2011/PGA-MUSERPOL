<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $materials = Material::all();
        return response()->json([
            'status' => true,
            'total' => $materials->count(),
            'materials' => $materials
        ]);
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
        try {
            logger($request);
            $material = new Material($request->input());

            if ($material->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Material Creado Correctamente',
                    'data' => $material,
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
                'message' => 'Ocurrio un error' . $e->getMessage()
            ],500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function materialslist(Request $request)
    {
        logger($request);
        $page = $request->get('page', -1);
        $limit = $request->get('limit', Material::count());
        $start = $page * $limit;
        $end = $limit * ($page + 1);

        $search = $request->input('search', '');

        $query = Material::orderBy('id');
        if ($query) {
            $query->where('description', 'like', '%' . $search . '%');
        }

        $totalmateriales = $query->count();

        $materials = $query->skip($start)->take($limit)->get();

        logger($materials);
        return response()->json([
            'status' => 'success',
            'total' => $totalmateriales,
            'page' => $page,
            'last_page' => ceil($totalmateriales / $limit),
            'materials' => $materials,
        ]);
    }
}
