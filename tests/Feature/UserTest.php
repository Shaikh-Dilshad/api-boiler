<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;
use App\UserAppointmentLetter;

class UserTest extends TestCase
{
  use DatabaseTransactions;

  public function setUp()
  {
    parent::setUp();

    $this->company = factory(\App\Company::class)->create([
      'name' => 'test'
    ]);
    $this->user->assignCompany($this->company->id);
    $this->headers['company-id'] = $this->company->id;

    $this->payload = [
      'name'                 => 'sangeetha',
      'phone'                => 9844778380,
      'email'                => 'sangeetha@gmail.com',
      'role_id'                 =>  3
    ];
  }

  /** @test */
  function user_must_be_logged_in()
  {
    $this->json('post', '/api/users')
      ->assertStatus(401);
  }

  /** @test */
  function it_requires_following_details()
  {
    $this->json('post', '/api/users', [], $this->headers)
      ->assertStatus(422)
      ->assertExactJson([
        "errors"  =>  [
          "name"                    =>  ["The name field is required."],
          "email"                   =>  ["The email field is required."],
          // "phone"                   =>  ["The phone field is required."],
          "role_id"  =>  ["The role id field is required."],
        ],
        "message" =>  "The given data was invalid."
      ]);
  }

  /** @test */
  function add_new_user()
  {
    $this->json('post', '/api/users', $this->payload, $this->headers)
      ->assertStatus(201)
      ->assertJson([
        'data'  =>  [
          'name'                 => 'sangeetha',
          'phone'                => 9844778380,
          'email'                => 'sangeetha@gmail.com',
          'role_id' => '3',
        ]
      ])
      ->assertJsonStructure([
        'data'  =>  [
          'name',
          'phone',
          'email',
        ]
      ])
      ->assertJsonStructureExact([
        'data'  =>  [
          'name',
          'email',
          'phone',
          'updated_at',
          'created_at',
          'id',
          'roles',
          'companies',
          // 'password_backup',
        ]
      ]);
  }

  /** @test */
  public function list_of_users()
  {
    $this->disableEH();
    $user = factory(\App\User::class)->create();
    $user->assignRole(3);
    $user->assignCompany($this->company->id);

    $this->json('get', '/api/users?role_id=3', [], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
        'data' => []
      ]);
    $this->assertCount(3, User::whereHas('roles',  function ($q) {
      $q->where('name', '!=', 'Admin');
      $q->where('name', '!=', 'Super Admin');
    })->get());
  }

  /** @test */
  public function list_of_users_of_report()
  {
    $this->disableEH();
    $user = factory(\App\User::class)->create();
    $user->assignRole(3);
    $user->assignCompany($this->company->id);

    $this->json('get', '/api/users?role_id=3&report=monthly', [], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
        'data' => []
      ]);
    $this->assertCount(3, User::whereHas('roles',  function ($q) {
      $q->where('name', '!=', 'Admin');
      $q->where('name', '!=', 'Super Admin');
    })->get());
  }

  /** @test */
  function show_single_user_details()
  {
    $this->json('get', "/api/users/1", [], $this->headers)
      ->assertStatus(200)
      ->assertJsonStructure([
        'data'  =>  [
          'name',
          'phone',
          'email'
        ]
      ]);
  }

  /** @test */
  function update_single_user_details()
  {
    $this->disableEH();
    $payload  = [
      'name'  =>  'sangeetha',
      'phone' =>  9088597123,
      'email' =>  'preethi@gmail.com',
      'doj'               =>  '12-02-2019',
      'dob'               =>  '04-05-1992',
      'pf_no'                   =>  '1234567654',
      'uan_no'                  =>  '1234565432',
      'esi_no'                  =>  '234565'
    ];
    $this->json('patch', '/api/users/1', $payload, $this->headers)
      ->assertStatus(200)
      ->assertJson([
        'data'    =>  [
          'phone' =>  9088597123,
          'email' =>  'preethi@gmail.com',
        ]
      ])
      ->assertJsonStructureExact([
        'data'  => [
          'id',
          'name',
          'email',
          'email_verified_at',
          'active',
          'phone',
          'api_token',
          'dob',
          'is_deleted',
          'created_at',
          'updated_at',
          'roles',
          'companies',
        ],
        'message',
        'success'
      ]);
  }
}
