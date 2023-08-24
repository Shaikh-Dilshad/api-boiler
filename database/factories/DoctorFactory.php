<?php

use App\Doctor;
use Faker\Generator as Faker;

$factory->define(Doctor::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'title'=>'title',
       'type'=>'type',
       'category'=>'category',
       'status'=>0
    ];
});
