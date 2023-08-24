<?php

namespace App\Http\Controllers;

use App\Notice;
use Illuminate\Http\Request;

class NoticeController extends Controller
{

       
    public function __construct()
    {
        $this->middleware(['company']);
    }

    public function index(Request $req)
    {
     $notice =  $req->company->notices();
     return response()->json([
         'data'  =>  $notice
     ]);
     
    }

    /*
   * To store a new value
   *
   *@
   */
    public function store(Request $request)
    {
        

        $notice = new Notice(request()->all());
        $request->company->notices()->save($notice);
    

        return response()->json([
            'data'    =>  $notice
        ], 201);
    }

    /*
   * To view a single value
   *
   *@
   */
    public function show(Notice $notice)
    {
       
        return response()->json([
            'data'   =>  $notice,
            'success' =>  true
        ], 200);
    }

    /*
   * To update a value
   *
   *@
   */
    public function update(Request $request, Notice $notice)
    {
        $notice->update($request->all());
        // dd($notice);

        return response()->json([
            'data'  =>  $notice
        ], 200);
    }

    public function destroy($id)
    {
        $notice = Notice::find($id);
        $notice->delete();

        return response()->json([
            'message' =>  'Deleted'
        ], 204);
    }
} 
