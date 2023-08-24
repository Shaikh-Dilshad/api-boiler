<?php

namespace App\Http\Controllers;

use App\Ticket;
use Illuminate\Http\Request;


class TicketController extends Controller
{

       
       public function __construct()
       {
           $this->middleware(['company']);
       }
   
       public function index(Request $req)
       {
        $value =  $req->company->tickets();
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
           
   
           $value = new Ticket(request()->all());
           $request->company->tickets()->save($value);
   
           return response()->json([
               'data'    =>  $value
           ], 201);
       }
   
       /*
      * To view a single value
      *
      *@
      */
       public function show(Ticket $value)
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
       public function update(Request $request, Ticket $value)
       {
           $value->update($request->all());
   
           return response()->json([
               'data'  =>  $value
           ], 200);
       }
   
       public function destroy($id)
       {
           $value = Ticket::find($id);
           $value->delete();
   
           return response()->json([
               'message' =>  'Deleted'
           ], 204);
       }
} 
  

