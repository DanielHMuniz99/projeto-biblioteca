<?php

namespace Database\Factories;

use App\Models\LibraryUser;
use Illuminate\Database\Eloquent\Factories\Factory;

class LibraryUserFactory extends Factory
{
    protected $model = LibraryUser::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'registration_number' => 'U-' . $this->faker->unique()->numberBetween(100, 999),
        ];
    }
}
