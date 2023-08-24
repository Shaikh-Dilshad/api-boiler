<?php

use App\Blog;
use Faker\Generator as Faker;

$factory->define(Blog::class, function (Faker $faker) {
    return [
        'user_id'=>1,
        'title'=>'title',
       ' type'=>'type',
       'category'=>'category',
       'status'=>0
        ];
});
