<?php

namespace Database\Seeders;

use App\Models\CategoryOfExpense;
use Illuminate\Database\Seeder;

class CategoryOfExpenseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = [
            [
                'name' => 'Utilitarios',
            ],
            [
                'name' => 'Operativo',
            ],
            [
                'name' => 'Insumos',
            ],
            [
                'name' => 'Vaucher',
            ],
            [
                'name' => 'Mantenimiento',
            ],
            [
                'name' => 'Vales',
            ],
            [
                'name' => 'Pago de nomina',
            ],
            [
                'name' => 'Otros Gastos',
            ],
        ];

        foreach ($categories as $category) {
            CategoryOfExpense::create($category);
        }
    }
}
