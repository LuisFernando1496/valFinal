<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

class ExpenseFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
                'title'=>"Gasto". rand(1,20),
                'description'=>'Descripcion del gasto'. rand(1,20),
                'total'=>rand(1,1000),
                'date' => Carbon::now(),
                'category_of_expense_id' => rand(1,8),
                'user_id' => 1,
                'owner_id'  => rand(1,19),
                'office_id'=> rand(1,2),
        ];
    }
}
