<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->name,
            'last_name'=>$this->faker->lastName,
            'second_last_name'=>$this->faker->lastName,
            'phone'=> $this->faker->regexify("961[1-9]{7}"),
            'email'=>$this->faker->email,
            'rfc'=> $this->faker->regexify("[A-Z]{4}[0-9]{6}[A-Z]{1}[1-9]{1}[A-Z]{1}"),
            'curp'=> $this->faker->regexify("[A-Z]{4}[0-9]{6}[A-Z]{6}[1-9]{2}"),
            'date'=>$this->faker->date,
            'address_id'=>rand(1,2),
            'office_id'=>rand(1,2),
        ];
    }
}
