<?php

namespace Database\Factories;

use App\Models\Company;
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
        $freeDayReqIDs = FreeDaysRequest::all()->pluck('id')->toArray();
        $fileIDs = File::all()->pluck('id')->toArray();
        return [
            'free_day_req_id' => fake()->randomElement($freeDayReqIDs),
            'file_id' => fake()->randomElement($fileIDs),
        ];
    }
}
