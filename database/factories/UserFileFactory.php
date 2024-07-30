<?php

namespace Database\Factories;

use App\Models\Company;
use App\Models\File;
use App\Models\UserFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UserFile>
 */
class UserFileFactory extends Factory
{

    public function definition(): array
    {
        $companyId = File::all()->pluck('id')->toArray();
        $userId = File::all()->pluck('id')->toArray();
        return [
            'file_id'=>fake()->randomElement($companyId),
            'user_id'=>fake()->randomElement($userId),
        ];
    }
}
