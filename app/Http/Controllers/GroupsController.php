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
    public function index()
    {
        
        $groups = Group::all();
        if($groups){
            return response()->json([
                'status' => true,
                'data' => $groups
            ],200);
        }else{
            return response()->json([
                'status'=>false,
                'message'=>"no "
            ],404);
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
            'name_group'=>'required|string|max:255',
            'state'=>'required|string|max:1',
            'classifier_id'=>'required'
        ]);
       
       
        $group = Group::create($validate);
        return response()->json([
            'data'=>$group
        ],201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $group = Group::findOrFail($id);
        $classifier= Classifier::find($group->classifier_id);
        return response()->json([
            'data'=>$group,
            'classifier'=>$classifier
        ],200);
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
            'name_group'=>'string|max:255',
            'state'=>'string|max:1',
        ]);

        $group = Group::findOrFail($id);
        $group->update($validate);
        return response()->json(['data'=>$group],200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $group = Group::findOrFail($id);
        $group->delete();
        return response()->json(['message'=>'Eliminado'],200);
    }
}
