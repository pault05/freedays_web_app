<?php

namespace Database\Factories;

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
        return [
            'user_id' => $this->faker->numberBetween(1, 10),
            'category_id'=> $k%4,
            'status' => 'Pending',
            'starting_date' => fake()->dateTimeBetween('2024-07-15', '2024-12-31')->format('Y-m-d'),
            'ending_date' => fake()->dateTimeBetween('2024-07-15', '2024-12-31')->format('Y-m-d'),
            'half_day' => fake()->boolean,
            'description' => fake()->colorName(),
            #'deleted_at' => now(),
        ];
    }
}
