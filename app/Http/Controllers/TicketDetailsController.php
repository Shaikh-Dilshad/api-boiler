<?php

namespace App\Http\Controllers;

use App\Ticketdetail;
use Illuminate\Http\Request;


class TicketDetailsController extends Controller
{
  
    public function __construct()
    {
        $this->middleware(['auth:api' ]); // Only apply 'auth:api' middleware
    }
    
       
   
       public function index(Request $req)
       {
        $Ticketdetail=$req->user()->ticketdetails();
        return response()->json(
            [
                'data'=>$Ticketdetail

            ],200);
       }
   
       /*
      * To store a new value
      *
      *@
      */
      public function store(Request $request)
      {
          $Ticketdetail = new Ticketdetail(request()->all());
          $request->user()->ticketdetails()->save($Ticketdetail);
      
          return response()->json([
              'data'    =>  $Ticketdetail
          ], 201);
      }
      
   
       /*
      * To view a single value
      *
      *@
      */
       public function show(Ticketdetail $Ticketdetail)
       {
        return response()->json([
            'data'=>$Ticketdetail
        ]);
       }
   
       /*
      * To update a value
      *
      *@
      */
       public function update(Request $request, Ticketdetail $Ticketdetail)
       {
         $Ticketdetail->update($request->all());
         return response()->json([
            'data'=>$Ticketdetail

         ]);
       }
   
       public function destroy(Ticketdetail $Ticketdetail)
       {
        $Ticketdetail->delete();
        return response()->json([
            'message'=>'deleted'
        ],204);
           
       }
  } 
  

