<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use App\Doctor;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class DoctorTest extends TestCase
{
   use DatabaseTransactions;
    public function setUp()
    {
    parent::setUp();
    $this->company = factory(\App\Company::class)->create([
    'name'=>'test'
    ]);
    $this->headers['company-id'] = $this->company->id;
    factory(Doctor::class)->create([
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
    public function to_check_new_doctor(){
        $this->json('post','api/doctors',$this->payload,$this->headers)
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
        $this->json('get','api/doctors',[],$this->headers)
        ->assertStatus(200)
        ->assertJsonStructure([
            'data'=>[
                '*'=>[
                    'title'
                    ]
            ]
            ]);
            $this->assertCount(1,Doctor::all());
    }
    /**
     * @test
     */
    public function get_single_value(){
        $this->json('get','api/doctors/1',[],$this->headers)
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
    public function to_update_doctor_details(){
        $payload=[
            'user_id'=>1,
            'title'=>'title',
           'type'=>'type',
           'category'=>'category',
           'status'=>1
        ];
        $this->json('patch','api/doctors/1',$payload,$this->headers)
        ->assertStatus(201)
        ->assertJsonStructureExact([
            'data' => [
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
    public function delete_doctor_details(){
        $this->json('delete','api/doctors/1',[],$this->headers)
        ->assertStatus(204);
        $this->assertCount(0,Doctor::all());
    }
}
