<?php

use App\Project;
use Faker\Generator as Faker;

$factory->define(Project::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'title'=>'title',
       'type'=>'type',
       'category'=>'category',
       'status'=>0
        ];
});
