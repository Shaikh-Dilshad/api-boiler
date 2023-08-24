<?php

namespace App\Http\Controllers;

use App\ProgramPost;
use Illuminate\Http\Request;

class ProgramPostController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $programpost =  $req->company->programposts();
     return response()->json([
         'data'  =>  $programpost
     ]);
     
    }

    /*
   * To store a new value
   *
   *@
   */
    public function store(Request $request)
    {
        

        $programpost = new ProgramPost(request()->all());
        $request->company->programposts()->save($programpost);
    

        return response()->json([
            'data'    =>  $programpost
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(ProgramPost $programpost)
    {
       
        return response()->json([
            'data'   =>  $programpost,
            'success' =>  true
        ], 200);
    }

    /*
   * To update a value
   *
   *@
   */
    public function update(Request $request, ProgramPost $programpost)
    {
        $programpost->update($request->all());
        // dd($programpost);

        return response()->json([
            'data'  =>  $programpost
        ], 200);
    }

    public function destroy($id)
    {
        $programpost = ProgramPost::find($id);
        $programpost->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 

