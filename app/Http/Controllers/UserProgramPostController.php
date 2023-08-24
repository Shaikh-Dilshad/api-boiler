<?php

namespace App\Http\Controllers;

use App\UserProgramPost;
use Illuminate\Http\Request;

class UserProgramPostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['company']);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $req)
    {
        $Userprogrampost = $req->company->userprogramposts();
        dd($Userprogrampost);
       return response()->json([
        'data'=>$Userprogrampost
       ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request);
       $Userprogrampost = new UserProgramPost(request()->all());
       
       $request->company->userprogramposts()->save($Userprogrampost);
       return response()->json([
        'data'=>$Userprogrampost
       ]);
    }

    /**
     * Display the specified resource.
     *
     * @
     */
    public function show(UserProgramPost $Userprogrampost)
    {  
        // dd($Userprogrampost);
        // $result = $req
        // $result = UserProgramPost::find($id);
        return response()->json([
          'data'=>$Userprogrampost,
          'success'=>true
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
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
    public function update(Request $request, UserProgramPost $Userprogrampost)
    {
       $Userprogrampost->update($request->all());
    //    dd($Userprogrampost);
       return response()->json([
         'data'=>$Userprogrampost
       ]); 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserProgramPost $Userprogrampost)
    {
        $Userprogrampost->delete();
        return response()->json([
            'message' =>  'Deleted'
        
        ],204);
    }
}
