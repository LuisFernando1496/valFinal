<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Ficha_Tecnica;

class Ficha_TecnicaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $questions = [
            [
                'pregunta' => 'Es alérgico a algún medicamento',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Presión Arterial',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Diabetes',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Problemas de coagulación',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Pulmonares',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Asma',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Glándula tiroides',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Problemas Hepáticos',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Cardiacos',
                'category_id' => 1
            ],
            [
                'pregunta' => 'Fumas',
                'category_id' => 2
            ],
            [
                'pregunta' => 'Ha recibido tratamiento médico últimamente',
                'category_id' => 2
            ],
            [
                'pregunta' => 'Toma medicamentos para dormir o para los nervios',
                'category_id' => 2
            ],
            [
                'pregunta' => 'Tipo de cirugía',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Fecha de cirugía',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Nombre del médico',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Contacto del médico',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Número de sesiones recomendadas',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Área a tratar',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Primera sesión',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Segunda sesión',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Tercera sesión',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Nombre del terapeuta',
                'category_id' => 3
            ],
            [
                'pregunta' => 'Observaciones',
                'category_id' => 3
            ]
        ];

        foreach($questions as $question)
        {
            Ficha_Tecnica::create($question);
        }
    }
}
