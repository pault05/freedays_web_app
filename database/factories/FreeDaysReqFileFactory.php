<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\FreeDaysRequest;
use App\Models\FreeDaysReqFile;
use App\Models\File;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FreeDaysReqFile>
 */
class FreeDaysReqFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'free_day_req_id' => $this->faker->numberBetween(1, 10),
            'file_id' => $this->faker->numberBetween(1, 10),
        ];
    }
}
