<?php

namespace Database\Factories;

use App\Models\Company;
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
        $companyId = Company::all()->pluck('id')->toArray();
        return [
            'name' => fake()->name(), //doar pt seeder
            'date' => $this->faker->dateTimeBetween('2024-07-01', '2024-07-31')->format('Y-m-d'),
            'created_at' => now(),
            'updated_at' => now(),
            'company_id' => fake()->randomElement($companyId),
        ];
    }
}
