<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use function Laravel\Prompts\table;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'password' => static::$password ??= Hash::make('password'),
            'company_id' => fake()->randomElement([1, 2, 3, 4, 5, 6, 7, 8, 9, 10]), //TODO
            'position' => fake()->jobTitle(),
            'phone' => fake()->phoneNumber(),
            'is_admin' => fake()->boolean(),
            'free_days' => fake()->randomElement([10, 15, 21, 25]),
            'created_at' => now(),
            'updated_at' => now(),
            'color' => fake()->randomElement([
                '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A1FF33', '#33A1FF',
                '#FF3380', '#80FF33', '#3380FF', '#FF8333', '#33FF83', '#8333FF',
                '#FF3333', '#33FF33', '#3333FF'
            ]),
            'deleted_at' => null,
            'hired_at' => null,
            ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
