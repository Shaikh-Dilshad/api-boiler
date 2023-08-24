<?php

namespace Tests\Feature;

use App\Company;
use App\UserProgram;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserProgramTest extends TestCase
{
   use DatabaseTransactions;
   public function setUp(){
      parent::setUp();
      $this->company = factory(\App\Company::class)->create([
        'name'=>'test'
      ]
      );
      $this->headers['company-id'] = $this->company->id;
      factory(UserProgram::class)->create([
        'company_id' => $this->company->id
    ]);
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
    public function to_chect_post_or_not(){
        $this->disableEH();
        $this->json('post','api/userprograms', $this->payload , $this->headers)
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
    }

    /**
     * @test
     */
    public function show_all(){
        $this->disableEH();
        $this->json('GET','api/userprograms',[],$this->headers)
        ->assertStatus(200)
        ->assertJsonStructure([
            'data' => [
               '*' => [
                  'title'
               ]
            ]
            ]);
            $this->assertCount(1 , UserProgram::all());

    }
    /**
     * @test
     */
    public function show_single_list(){
        $this->json('GET','api/userprograms/1',[],$this->headers)
        ->assertStatus(200)
        ->assertJson([
            'data' => [
                'user_id'=>1,
                'title'=>'title',
                'type'=>'type',
                'category'=>'category',
                'status'=>'status'
            ]
        ]);

    }
    /**
     * @test
     */
    public function update_value(){
        $payload = [
            'user_id'=>1,
            'title'=>'title2',
            'type'=>'type2',
            'category'=>'category',
            'status'=>'status'
        ];
        $this->json('patch','/api/userprograms/1', $payload, $this->headers)
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
    }

    /**
     * @test
     */
    public function delete_values(){
        $this->json('delete' ,'/api/userprograms/1',[],$this->headers)
        ->assertStatus(204);
        $this->assertCount(0 , UserProgram::all());
    }
}
