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
            'name' => fake()->colorName(), //doar pt seeder
            // 'date' => $this->faker->date($format = 'Y-m-d'),
            'date' => $this->faker->dateTimeBetween($startDate = 'now', $endDate = '2026-12-31'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
