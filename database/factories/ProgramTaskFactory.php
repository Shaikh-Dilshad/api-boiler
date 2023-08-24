<?php


use App\ProgramTask;
use Faker\Generator as Faker;

$factory->define(ProgramTask::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'title'=>'title',
       'type'=>'type',
       'category'=>'category',
       'status'=>0
       
        ];
});
