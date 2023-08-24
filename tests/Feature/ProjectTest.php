<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;


class ProjectTest extends TestCase
{
  
    use DatabaseTransactions;
    public function setUp()
    {
      parent::setUp();
  
      $this->company = factory(\App\Company::class)->create([
        'name' => 'test'
      ]);
      $this->headers['company-id'] = $this->company->id;
      factory(Project::class)->create();
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
       $result = $this->json('post' , 'api/projects' ,$this->payload , $this->headers)
       ->assertStatus(201);
       $this->assertCount(2 , Project::all());
    }
    
    /**
     * @test
     */

    public function check_all_list(){

        $this->disableEH();
        $this->json('GET', '/api/projects',[],  $this->headers)
            ->assertStatus(200);
    }

        /** @test */
        function show_single_value()
        {
    
            $this->json('get', "/api/projects/1", [], $this->headers)
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
    
            $this->json('patch', '/api/projects/1', $payload, $this->headers)
                ->assertStatus(200);
        }

           /** @test */
    function delete_value()
    {
        $this->json('delete', '/api/projects/1', [], $this->headers)
        ->assertStatus(204);
        $this->assertCount(0, Project::all());
    }



    
   
}

