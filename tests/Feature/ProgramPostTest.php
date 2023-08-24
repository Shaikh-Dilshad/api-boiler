<?php

namespace Tests\Feature;

use App\ProgramPost;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ProgramPostTest extends TestCase
{
  
    use DatabaseTransactions;
    public function setUp()
    {
      parent::setUp();
  
      $this->company = factory(\App\Company::class)->create([
        'name' => 'test'
      ]);
      
      $this->headers['company-id'] = $this->company->id;
      factory(ProgramPost::class)->create([
        'company_id' =>  $this->company->id
    ]);
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
       $result = $this->json('post' , 'api/programposts' ,$this->payload , $this->headers)
       ->assertStatus(201)
       ->assertJsonStructureExact([
           'data'   => [
               'user_id',
               'title',
               'type',
               'category',
               'status',
               'company_id',
               'updated_at',
               'created_at',
               'id'
               ]
            ]);

            $this->assertCount(2 , ProgramPost::all());
    }
    
    /**
     * @test
     */

    public function check_all_list(){

        $this->disableEH();
        $this->json('GET', '/api/programposts',[],  $this->headers)
            ->assertStatus(200)
            ->assertJsonStructure([
                'data'  => [
                    '*' =>  [
                        'title'
                    ]   
                ]
            ]);
        $this->assertCount(1, ProgramPost::all());

    }

        /** @test */
        function show_single_value()
        {
    
            $this->json('get', "/api/programposts/1", [], $this->headers)
                ->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'user_id' => 1,
                        'title' => 'title',
                        'type' => 'type',
                        'category' => 'category',
                        'status' => 0
                    ]
                ]);
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
    
            $this->json('patch', '/api/programposts/1', $payload, $this->headers)
                ->assertStatus(200)
                ->assertJson([
                    'data' => [
                        'user_id'=>1,
                        'title'=>'title2',
                         'type'=>'type',
                         'category'=>'category',
                         'status'=>0 
                    ]
                ])
                ->assertJsonStructureExact([
                    'data'   => [
                        'id',
                        'company_id',
                        'user_id',
                        'title',
                        'type',
                        'category',
                        'status',
                        'created_at',
                        'updated_at',
                        
                        ]
                     ]);
        }

           /** @test */
    function delete_value()
    {
        $this->json('delete', '/api/programposts/1', [], $this->headers)
        ->assertStatus(204);
        $this->assertCount(0, ProgramPost::all());
    }



    
   
}
