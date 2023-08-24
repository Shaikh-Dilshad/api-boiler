<?php

use Faker\Generator as Faker;
use App\Ticket;

$factory->define(Ticket::class, function (Faker $faker) {
    return [
       'user_id'=>1,
       'title'=>'title',
      ' type'=>'type',
      'category'=>'category',
      'status'=>0
       ];
});
