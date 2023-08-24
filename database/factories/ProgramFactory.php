<?php

use App\Program;
use Faker\Generator as Faker;

$factory->define(Program::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'title'=>'title',
       'type'=>'type',
       'category'=>'category',
       'status'=>0
       
        ];});
