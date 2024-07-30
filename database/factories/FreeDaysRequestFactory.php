<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Company;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FreeDaysRequest>
 */
class FreeDaysRequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $k=1;
        $k++;

        $startingDate = $this->faker->dateTimeBetween('2024-07-15', '2024-12-31');
        $endingDate = $this->faker->dateTimeBetween($startingDate, '2024-12-31');

        $usersIDs = User::all()->pluck('id')->toArray();
        $categoriesIDs = Category::all()->pluck('id')->toArray();

        return [
            'user_id' => fake()->randomElement($usersIDs),
            'category_id'=> fake()->randomElement($categoriesIDs),
            'status' => 'Pending',
            'starting_date' => $startingDate->format('Y-m-d'),
            'ending_date' => $endingDate->format('Y-m-d'),
            'half_day' => fake()->boolean,
            'description' => fake()->colorName(),
            'days' => fake()->numberBetween(1, 3),
        ];
    }
}
