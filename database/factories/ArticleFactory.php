<?php
/**
 * Created by PhpStorm.
 * User: Transcendent-PC
 * Date: 5/15/2020
 * Time: 7:35 PM
 */

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    $articleName = $faker->name;

    return [
        'name'           => $articleName .' brand shoes',
        'description'    => $articleName . ' brand shoes description',
        'price'          => $faker->numberBetween(30, 200),
        'total_in_shelf' => $faker->numberBetween(0, 50),
        'total_in_vault' => $faker->numberBetween(0, 50),
    ];
});