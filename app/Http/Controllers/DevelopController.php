<?php

namespace App\Http\Controllers;

use App\Develop;
use Illuminate\Http\Request;

class DevelopController extends Controller
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
    public function index(Request $request)
    {
        $Develop=$request->company->develops();
        return response()->json([
          'data'=>$Develop
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
       $Develop = new Develop($request->all());
       $request->company->develops()->save($Develop);
        return response()->json([
           'data'=>$Develop
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Develop $Develop)
    {
        return response()->json([
            'data'=>$Develop

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
    public function update(Request $request, Develop $Develop)
    {
        $Develop->update($request->all());

        return response()->json([
         'data'=>$Develop
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Develop $Develop)
    {
        $Develop->delete();
        return response()->json([
         'message'=>'deleted'
        ],204);
    }
}
