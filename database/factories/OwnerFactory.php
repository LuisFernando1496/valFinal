<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class OwnerFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'owner_name' => $this->faker->name,
            'owner_phone' => $this->faker->regexify("961[1-9]{7}")
        ];
    }
}
