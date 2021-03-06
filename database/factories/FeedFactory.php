<?php

use Faker\Generator as Faker;

use App\Models\Feed;
use App\Models\FeedStatus;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Feed::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence,
        'url' => $faker->url,
        'homepage' => $faker->url,
        'type' => collect(['rss', 'podcast'])->random()
    ];
});

$factory->afterMaking(Feed::class, function (Feed $feed) {
    $feed->statuses->add(factory(FeedStatus::class)->make());
});