<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Company;
use App\Ticket;

use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tickets;

class TicketTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function setUp()
    {
      parent::setUp();
  
      $this->company = factory(\App\Company::class)->create([
        'name' => 'test'
      ]);
      $this->headers['company-id'] = $this->company->id;
  
     $this->payload = [
        'user_id'=>1,
       'title'=>'title',
        'type'=>'type',
        'category'=>'category',
        'status'=>0 
     ];
    }

    /**
     * @test
     */
    public function to_check_post_or_not(){
        $this->disableEH();
       $result = $this->json('post' , 'api/tickets' ,$this->payload , $this->headers)
       ->assertStatus(201);
       $this->assertCount(1 , Ticket::all());
    }

    public function check_all_list(){
        $this->disableEH();
        $this->json('GET', '/api/tickets/1',  $this->headers)
            ->assertStatus(200);
    }

        /** @test */
        function show_single_value()
        {
    
            $this->json('get', "/api/tickets/1", [], $this->headers)
                ->assertStatus(200);
        }

        /**
         * @test
         */
        function update_single_value()
        {
            $payload = [
                'user_id'=>1,
                'title'=>'title2',
                 'type'=>'type',
                 'category'=>'category',
                 'status'=>0 
            ];
    
            $this->json('patch', '/api/tickets/1', $payload, $this->headers)
                ->assertStatus(200);
        }

           /** @test */
    function delete_value()
    {
        $this->json('delete', '/api/tickets/1', [], $this->headers)
        ->assertStatus(204);
        $this->assertCount(0, Ticket::all());
    }



    
   
    
}
