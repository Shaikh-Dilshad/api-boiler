<?php

namespace Tests\Feature;

use App\Company;
use App\Paper;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaperTest extends TestCase
{
   use DatabaseTransactions;
    public function setUp()
    {
     parent::setUp();
     $this->company = factory(\App\Company::class)->create([
       'name'=>'test'
     ]);
     $this->headers['company-id'] = $this->company->id;
     factory(Paper::class)->create([
        'company_id'=>$this->company->id
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
    public function to_store_paper_details(){
        $this->json('post','api/papers',$this->payload,$this->headers)
        ->assertStatus(200)
        ->assertJsonStructureExact([
            'data'=>[
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
    public function show_all_papers(){
        $this->json('get','api/papers',[],$this->headers)
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'=>[
                '*'=>[
                    'title'
                    ]
            ]
            ]);
            $this->assertCount(1,Paper::all());

    }
    /**
     * @test
     */
    public function show_single_paper(){
        $this->json('get','api/papers/1',[],$this->headers)
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
    public function update_value(){
        $payload =[
            'user_id'=>1,
            'title'=>'title',
            'type'=>'type',
            'category'=>'category',
            'status'=>1
        ];
        $this->json('patch','api/papers/1',$payload,$this->headers)
        ->assertStatus(200)
        ->assertJson([
            'data'=>[
            'user_id'=>1,
            'title'=>'title',
            'type'=>'type',
            'category'=>'category',
            'status'=>1
            ]
        ])
        ->assertJsonStructureExact([
            'data'=>[
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
    public function delete_value(){
        $this->json('delete','api/papers/1',[],$this->headers)
        ->assertStatus(204);
        $this->assertCount(0,Paper::all());
    }

}
