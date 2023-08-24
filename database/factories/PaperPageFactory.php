<?php

use App\PaperPage;
use Faker\Generator as Faker;

$factory->define(PaperPage::class, function (Faker $faker) {
    return [
        'paper_id'=>1,
        'title'=>'title'
    ];
});
