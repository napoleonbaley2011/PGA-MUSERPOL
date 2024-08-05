<?php

namespace App\Http\Controllers;

use App\Models\Material;
use Illuminate\Http\Request;
use App\Http\Requests\MaterialRequest;

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
    public function store(MaterialRequest $request)
    {
        try {
            // Extrae los datos de la solicitud y crea una nueva instancia de Material
            $data = $request->validated(); // Asegura que solo se validen los datos
            $material = new Material($data);

            if ($material->save()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Material Creado Correctamente',
                    'data' => $material,
                ], 201);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'No se pudo crear el material.',
                ], 403);
            }
        } catch (\Exception $e) {
            // Manejo de errores más específico si es necesario
            return response()->json([
                'status' => false,
                'message' => 'Ocurrió un error: ' . $e->getMessage(),
            ], 500);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $material = Material::findOrFail($id);


        $entries = $material->noteEntries()->withPivot('amount_entries', 'request', 'cost_unit', 'cost_total')->wherePivot('request ', '>', 0)->get();


        $response = $entries->map(function ($entry) {
            return [
                'note_id' => $entry->id,
                'note_number' => $entry->number_note,
                'date' => $entry->delivery_date,
                'amount_entries' => $entry->pivot->amount_entries,
                'request' => $entry->pivot->request,
                'cost_unit' => $entry->pivot->cost_unit,
                'cost_total' => $entry->pivot->cost_total,
            ];
        });


        return response()->json([
            'material_id' => $material->id,
            'material_description' => $material->description,
            'entries' => $response,
        ], 200);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $material = Material::find($id);
        if ($request['state'] == "Habilitado") {
            $upState = "Inhabilitado";
        } else {
            if ($material->stock > 0) {
                $upState = "Habilitado";
            } else {
                return response()->json([
                    'status' => false,
                    'message' => "Debe existir Stock para poder Habilitar el material"
                ], 400);
            }
        }
        $material->state = $upState;
        //logger($material);
        $material->save();
        return response()->json(['status' => true, 'data' => $material], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Material $material)
    {
        $material->delete();
        return response()->json(['message' => 'Eliminado'], 200);
    }

    public function materialslist(Request $request)
    {
        $page = max(0, $request->get('page', 0)); // Asegurarse de que la página sea al menos 0
        $limit = max(1, $request->get('limit', Material::count())); // Asegurarse de que el límite sea al menos 1
        $start = $page * $limit;

        $search = $request->input('search', '');

        $query = Material::orderBy('id');
        if ($search) {
            $query->where('description', 'like', '%' . $search . '%')
                ->orWhere('code_material', 'like', '%' . $search . '%');
        }

        $totalMaterials = $query->count();

        $materials = $query->skip($start)->take($limit)->get();

        $materials->each(function ($material) {
            if ($material->stock <= 0 && $material->state !== 'Inhabilitado') {
                $material->state = 'Inhabilitado';
                $material->save();
            }
        });

        return response()->json([
            'status' => 'success',
            'total' => $totalMaterials,
            'page' => $page,
            'last_page' => ceil($totalMaterials / $limit),
            'materials' => $materials,
        ]);
    }

    public function materialslist_petty_cash(Request $request)
    {
        //logger($request);
        $page = $request->get('page', -1);
        $limit = $request->get('limit', Material::count());
        $start = $page * $limit;
        $end = $limit * ($page + 1);

        $search = $request->input('search', '');

        $query = Material::orderBy('id')
            ->where(function ($query) {
                $query->where('type', 'Caja Chica')
                    ->orWhere('type', 'Fondo de Avance');
            });

        if ($search) {
            $query->where('description', 'like', '%' . $search . '%');
        }

        $totalmateriales = $query->count();
        $materials = $query->skip($start)->take($limit)->get();

        return response()->json([
            'status' => 'success',
            'total' => $totalmateriales,
            'page' => $page,
            'last_page' => ceil($totalmateriales / $limit),
            'materials' => $materials,
        ]);
    }


    public function list_materials_pva()
    {
        $query = Material::where('state', 'Habilitado')->get();
        // logger($query);
        return $query;
    }

    public function updateName(Request $request, string $id)
    {
        $material = Material::find($id);


        $material->description = $request['description'];
        $material->unit_material = $request['unit_material'];

        $material->save();
        return response()->json(['status' => true, 'data' => $material], 200);
    }
}
