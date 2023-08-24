<?php

namespace Tests\Feature;

use App\Ticketdetail;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;



class TicketDetailsTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    use DatabaseTransactions;
    public function setUp()
    {
      parent::setUp();
  
      $this->user = factory(\App\User::class)->create();
      $this->headers['user-id'] = $this->user->id;
      factory(Ticketdetail::class)->create(
        [
          'user_id'=>$this->user->id
        ]
        );

     $this->payload = [
        'ticket_id'=>1,
        'description'=>'description'
     ];
    }
  

    /**
     * @test
     */
    public function to_check_post_or_not(){
        $this->disableEH();
       $result = $this->json('post' , 'api/ticketdetails' ,$this->payload , $this->headers)
       ->assertStatus(201)
       ->assertJsonStructureExact([
         'data'=>[   
        'ticket_id',
        'description',
        'user_id',
        'updated_at',
        'created_at',
        'id'
         ]
       ]);
       $this->assertCount(2 , Ticketdetail::all());
       
    }
    /**
     * @test
     */
    public function show_all(){
        $this->json('get','api/ticketdetails',[],$this->headers)
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'=>[
                '*'=>[
                  'description'
                ]
                ]
        ]);
    }
    /**
     * @test
     */
    public function show_single_list(){
        $this->json('get','api/ticketdetails/1',[],$this->headers)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'ticket_id'=>1,
        'description'=>'description'
            ]
            ]);
        $this->assertCount(1,Ticketdetail::all());
    }
    /**
     * @test
     */
    public function update_value(){
        $payload = [
            'ticket_id'=>1,
            'description'=>'dilshad'
        ];
        $this->json('patch','api/ticketdetails/1',$payload,$this->headers)
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'=>[
                'ticket_id',
            'description'
            ]
        ]);
    }
    /**
     * @test
     */
    public function delete_value(){
        $this->json('delete','api/ticketdetails/1',[],$this->headers)
        ->assertStatus(204);
        $this->assertCount(0,Ticketdetail::all());
    }


}
