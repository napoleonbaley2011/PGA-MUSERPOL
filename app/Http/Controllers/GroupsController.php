<?php

namespace App\Http\Controllers;

use App\Models\Classifier;
use App\Models\Group;
use Illuminate\Http\Request;
use PhpParser\Builder\Class_;

class GroupsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $page = $request->get('page', 0);
        $limit = $request->get('limit', Group::count());
        $start = $page * $limit;
        $search = $request->input('search', '');

        // Construimos la consulta inicial
        $query = Group::with(['materials', 'classifier' => function ($query) {
            $query->select('id', 'code_class', 'nombre as classifier_name');
        }]);

        // Aplicamos la búsqueda si existe el parámetro
        if (!empty($search)) {
            $query->whereHas('materials', function ($materialQuery) use ($search) {
                $materialQuery->where('description', 'like', '%' . $search . '%');
            });
        }

        // Contamos el total de grupos que cumplen con los criterios de búsqueda
        $totalGroups = $query->count();

        // Obtenemos los grupos aplicando paginación
        $groups = $query->skip($start)->take($limit)->get()->map(function ($group) {
            unset($group->classifier->id);
            return $group;
        });

        // Verificamos si hay resultados y devolvemos la respuesta adecuada
        if ($groups->isNotEmpty()) {
            return response()->json([
                'status' => 'success',
                'total' => $totalGroups,
                'page' => $page,
                'last_page' => ceil($totalGroups / $limit),
                'data' => $groups
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => "No groups found"
            ], 404);
        }
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

        //return $request;

        $validate = $request->validate([
            'code' => 'required|string|max:255',
            'name_group' => 'required|string|max:255',
            'state' => 'required|string|max:1',
            'classifier_id' => 'required'
        ]);


        $group = Group::create($validate);
        return response()->json([
            'data' => $group
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::findOrFail($id);
        $classifier = Classifier::find($group->classifier_id);
        return response()->json([
            'data' => $group,
            'classifier' => $classifier
        ], 200);
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
        $validate = $request->validate([
            'code' => 'string|max:255',
            'name_group' => 'string|max:255',
            'state' => 'string|max:1',
        ]);

        $group = Group::findOrFail($id);
        $group->update($validate);
        return response()->json(['data' => $group], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return response()->json(['message' => 'Eliminado'], 200);
    }

    public function list_groups(string $id_classifier){
        {
            $groups = Group::with('materials')
                ->where('classifier_id', $id_classifier)
                ->get();
    
            return response()->json([
                'status' => 'success',
                'groups' => $groups,
            ], 200);
        }
    }
}
