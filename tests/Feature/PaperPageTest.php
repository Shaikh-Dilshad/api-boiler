<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class PaperPageTest extends TestCase
{
    use DatabaseTransactions;
    public function setUp()
    {
        parent::setUp();
      $this->user = factory(\App\User::class)->create();
      $this->headers['user-id']=$this->user->id;

    }
}
