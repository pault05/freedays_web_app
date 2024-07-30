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
            'date' => $this->faker->dateTimeBetween('2024-07-01', '2024-07-31')->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
            'company_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
