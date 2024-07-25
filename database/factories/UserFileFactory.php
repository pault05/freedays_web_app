<?php

namespace Database\Factories;

use App\Models\UserFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserFile>
 */
class UserFileFactory extends Factory
{

    public function definition(): array
    {
        return [
            'file_id'=>$this->faker->numberBetween(1,10),
            'user_id'=>$this->faker->numberBetween(1,10),
        ];
    }
}
