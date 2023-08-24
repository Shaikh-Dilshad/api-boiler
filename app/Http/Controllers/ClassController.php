<?php

namespace App\Http\Controllers;

use App\ClassCode;
use Illuminate\Http\Request;

class ClassController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $class =  $req->company->classcodes();
     return response()->json([
         'data'  =>  $class
     ]);
     
    }

    /*
   * To store a new value
   *
   *@
   */
    public function store(Request $request)
    {
        

        $class = new ClassCode(request()->all());
        $request->company->classcodes()->save($class);
    

        return response()->json([
            'data'    =>  $class
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(ClassCode $class)
    {
       
        return response()->json([
            'data'   =>  $class,
            'success' =>  true
        ], 200);
    }

    /*
   * To update a value
   *
   *@
   */
    public function update(Request $request, ClassCode $class)
    {
        $class->update($request->all());
        // dd($class);

        return response()->json([
            'data'  =>  $class
        ], 200);
    }

    public function destroy($id)
    {
        $class = ClassCode::find($id);
        $class->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 
