<?php

use App\Ticketdetail;
use Faker\Generator as Faker;

$factory->define(Ticketdetail::class, function (Faker $faker) {
    return [
      
        'ticket_id'=>1,
        'description'=>'description'
    ];
});
