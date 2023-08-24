<?php

namespace App\Http\Controllers;

use App\UserProgram;
use Illuminate\Http\Request;

class UserProgramController extends Controller
{
    public function __construct()
    {
        $this->middleware(['company']);
    }
    /**
     * Display a listing of the resource.
     *
     * @
     */
    public function index(Request $request)
    {
       $userprogram = $request->company->userprograms();
    //    dd($userprogram);
       return response()->json([
          'data' => $userprogram 
       ],200);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     * @
     */
    public function store(Request $request)
    {
       $userprogram = new UserProgram(request()->all());
    //    dd($userprogram);
       $request->company->userprograms()->save($userprogram);
       return response()->json([
        'data'  =>  $userprogram
       ],201);

    }

    /**
     * Display the specified resource.
     *
     * @
     */
    public function show(UserProgram $userprogram)
    {
        dd($userprogram);
       return response()->json([
        'data'=>$userprogram,
        'success'=>true
       ],200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, UserProgram $userprogram)
    {
        $userprogram->update($request->all());
        return response()->json([
         'data' => $userprogram
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProgram $userprogram)
    {
        $userprogram->delete();
        return response()->json([
            'message' =>  'Deleted'
        ], 204);

    }
}
