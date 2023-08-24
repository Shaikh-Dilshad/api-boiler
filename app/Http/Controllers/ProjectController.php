<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $value =  $req->company->projects();
     return response()->json([
         'data'  =>  $value
     ]);
     
    }

    /*
   * To store a new value
   *
   *@
   */
    public function store(Request $request)
    {
        

        $value = new Project(request()->all());
        $request->company->projects()->save($value);

        return response()->json([
            'data'    =>  $value
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(Project $value)
    {
        dd($value);
        return response()->json([
            'data'   =>  $value,
            'success' =>  true
        ], 200);
    }

    /*
   * To update a value
   *
   *@
   */
    public function update(Request $request, Project $value)
    {
        $value->update($request->all());

        return response()->json([
            'data'  =>  $value
        ], 200);
    }

    public function destroy($id)
    {
        $value = Project::find($id);
        $value->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 
