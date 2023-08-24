<?php

namespace App\Http\Controllers;

use App\Program;
use Illuminate\Http\Request;

class ProgramController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $program =  $req->company->programs();
     return response()->json([
         'data'  =>  $program
     ]);
     
    }

    /*
   * To store a new value
   *
   *@
   */
    public function store(Request $request)
    {
        

        $program = new Program(request()->all());
        $request->company->programs()->save($program);
    

        return response()->json([
            'data'    =>  $program
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(Program $program)
    {
       
        return response()->json([
            'data'   =>  $program,
            'success' =>  true
        ], 200);
    }

    /*
   * To update a value
   *
   *@
   */
    public function update(Request $request, Program $program)
    {
        $program->update($request->all());
        // dd($program);

        return response()->json([
            'data'  =>  $program
        ], 200);
    }

    public function destroy($id)
    {
        $program = Program::find($id);
        $program->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 

