<?php

namespace Database\Seeders;

use App\Models\Office;
use Illuminate\Database\Seeder;

class OfficeSeeders extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'name',
        // 'phone',
        // 'responsable',
        // 'address_id',
        // 'business_id',
        Office::create([
        'name' => 'Sucursal 1',
        'phone' => '9612314796',
        'responsable' => 'Rodrigo',
        'address_id' => 1,  
        'business_id' => 1,
        ]);
        Office::create([
        'name' => 'Sucursal 2',
        'phone' => '9612387132',
        'responsable' => 'Sam',
        'address_id' => 2,
        'business_id' => 2,
        ]);
    }
}
