<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use function PHPUnit\Framework\stringContains;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\OfficialHoliday>
 */
class OfficialHolidayFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(), //doar pt seeder
           // 'date' => $this->faker->date(),
            'starting_date' => fake()->dateTimeBetween('2024-07-15', '2026-12-31')->format('Y-m-d'),
            'ending_date' => fake()->dateTimeBetween('2024-07-15', '2026-12-31')->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
