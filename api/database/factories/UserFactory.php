<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'given_name' => $this->faker->unique()->words(2, true),
            'middle_name' => $this->faker->unique()->word(),
            'last_name' => $this->faker->unique()->words(2, true),
            'name_suffix' => null,
            'username' => $this->faker->unique()->safeEmail(),
            'password' => bin2hex(random_bytes(4)),
            'status' => 'active',
        ];
    }
}
