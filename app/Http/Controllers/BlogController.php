<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
class BlogController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $value =  $req->company->blogs();
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
        

        $value = new Blog(request()->all());
        $request->company->blogs()->save($value);

        return response()->json([
            'data'    =>  $value
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(Blog $value)
    {
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
    public function update(Request $request, Blog $value)
    {
        $value->update($request->all());

        return response()->json([
            'data'  =>  $value
        ], 200);
    }

    public function destroy($id)
    {
        $value = Blog::find($id);
        $value->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 
