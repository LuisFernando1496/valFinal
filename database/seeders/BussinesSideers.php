<?php

namespace Database\Seeders;

use App\Models\Business;
use Illuminate\Database\Seeder;

class BussinesSideers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // ame',
        // 'rfc',
        // 'legal_representative',
        // 'number'
        $bussines = [[
        'name' => 'Val',
        'rfc' => 'DHK120478LMN',
        'legal_representative' => 'Alberto Perez Zambrano',
        'number' => 9612314714
        ],
        [
        'name' => 'Agua',
        'rfc' => 'DHK120478LOP',
        'legal_representative' => 'Alberto',
        'number' => 9612387124
        ]
    ];
        foreach ($bussines as $bussine) {
            Business::create($bussine);
        }
    
    }
}
