<?php

use App\ClassCode;
use Faker\Generator as Faker;

$factory->define(ClassCode::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'title'=>'title',
       'type'=>'type',
       'category'=>'category',
       'status'=>0
       
        ];
});
