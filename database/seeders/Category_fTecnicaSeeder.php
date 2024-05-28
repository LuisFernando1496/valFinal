<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category_fTecnica;

class Category_fTecnicaSeeder extends Seeder
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
                'nombre' => 'Antecedentes Patologicos'
            ],
            [
                'nombre' => 'Antecedentes No Patologicos'
            ],
            [
                'nombre' => 'Datos Médicos'
            ]
        ];

        foreach ($categories as $categorie) {
            Category_fTecnica::create($categorie);
        }
    }
}
