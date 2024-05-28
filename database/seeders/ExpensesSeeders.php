<?php

namespace Database\Seeders;

use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ExpensesSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'title',
        // 'description',
        // 'total',
        // 'date',
        // 'status',
        // 'category_of_expense_id',
        // 'user_id',
        // 'office_id',
       
      $expense = Expense::factory(20)->create();

       
    }
}
