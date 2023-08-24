<?php

namespace App\Http\Controllers;

use App\Sku;
use Illuminate\Http\Request;

class SkuController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $value =  $req->company->skus();
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
        

        $value = new Sku(request()->all());
        $request->company->skus()->save($value);

        return response()->json([
            'data'    =>  $value
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(Sku $value)
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
    public function update(Request $request, Sku $id)
    {
        $id->update($request->all());

        return response()->json([
            'data'  =>  $id
        ], 200);
    }

    public function destroy($id)
    {
        $value = Sku::find($id);
        $value->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 

