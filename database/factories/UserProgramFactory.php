<?php

use App\UserProgram;
use Faker\Generator as Faker;

$factory->define(UserProgram::class, function (Faker $faker) {
    return [
        'id'=>1,
        'company_id'=>1,
        'user_id'=>1,
        'title'=>'title',
        'type'=>'type',
        'category'=>'category',
        'status'=>'status'
    ];
});
