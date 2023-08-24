<?php

namespace App\Http\Controllers;

use App\ProgramTask;
use Illuminate\Http\Request;

class ProgramTaskController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $programtask =  $req->company->programtasks();
     return response()->json([
         'data'  =>  $programtask
     ]);
     
    }

    /*
   * To store a new value
   *
   *@
   */
    public function store(Request $request)
    {
        

        $programtask = new ProgramTask(request()->all());
        $request->company->programtasks()->save($programtask);
    

        return response()->json([
            'data'    =>  $programtask
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(ProgramTask $programtask)
    {
       
        return response()->json([
            'data'   =>  $programtask,
            'success' =>  true
        ], 200);
    }

    /*
   * To update a value
   *
   *@
   */
    public function update(Request $request, ProgramTask $programtask)
    {
        $programtask->update($request->all());
        // dd($programtask);

        return response()->json([
            'data'  =>  $programtask
        ], 200);
    }

    public function destroy($id)
    {
        $programtask = ProgramTask::find($id);
        $programtask->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 

