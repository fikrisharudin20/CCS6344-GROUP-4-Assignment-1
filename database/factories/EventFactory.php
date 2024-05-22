<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Geocoder\Laravel\ProviderAndDumperAggregator as Geocoder;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class EventFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomUser = User::inRandomOrder()->first();

        $address = fake()->address();
        $coordinates = app('geocoder')->geocode($address)->get()->first()->getCoordinates();
        $lat = $coordinates->getLatitude();
        $long = $coordinates->getLongitude();

        return [
            'name' => fake()->words(3, true),
            'date' => fake()->date(),
            'startTime' => fake()->time(),
            'endTime' => fake()->time(),
            'address' => $address,
            'lat' => $lat,
            'long' => $long,
            'description' => fake()->text(),
            'price' => fake()->numberBetween(0, 200),
            'userID' => $randomUser->id,
        ];
    }
}