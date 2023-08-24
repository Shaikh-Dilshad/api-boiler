<?php

namespace Tests\Feature;


use App\UserProgramPost;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserProgramPostTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    use DatabaseTransactions;
     public function setUp(){
        parent::setUp();
        $this->company = factory(\App\Company::class)->create([
          'name'=>'test'
        ]);
        $this->headers['company-id'] = $this->company->id;
        factory(UserProgramPost::class)->create(
            [
                'company_id'=>$this->company->id
            ]
            );
            $this->payload = [
                'user_id'=>1,
                'title'=>'title',
                'type'=>'type',
                'category'=>'category',
                'status'=>'status'
            ];

     }

     /**
      * @test
      */
      public function value_post_or_not(){
        $this->disableEH();
        $this->json('post','api/userprogramposts',$this->payload ,$this->headers)
        ->assertStatus(200)
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
      }

      /**
       * @test
       */
      public function show_all(){
        $this->json('get','api/userprogramposts',[],$this->headers)
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
                '*' => [
                   'title'
                ]
        ]]);
        $this->assertCount(1,UserProgramPost::all());
      }
      /**
       * @test
       */
      public function show_single_value(){
        $this->disableEH();
        $this->json('GET' , 'api/userprogramposts/1',[],$this->headers)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'user_id'=>1,
                'title'=>'title',
                'type'=>'type',
                'category'=>'category',
                'status'=>0
            ]
        ]);

       
      }

      /**
       * @test
       */
      public function to_update_details(){
        $payload = [
            'user_id'=>1,
            'title'=>'title',
            'type'=>'type',
            'category'=>'category',
            'status'=>1
        ];
        $this->json('patch','api/userprogramposts/1',$payload ,$this->headers)
        ->assertStatus(200)
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
            $this->assertCount(1,UserProgramPost::all());
      }


      /**
       * @test
       */
      public function delete_value(){
        $this->json('delete','api/userprogramposts/1',[],$this->headers)
        ->assertStatus(204);
      }
}
