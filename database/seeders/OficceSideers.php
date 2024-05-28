<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Business;
use App\Models\Office;
use Illuminate\Database\Seeder;

class OficceSideers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Office::create([
        'name' => 'Tomatera',
        'phone' => 9861429614,
        'responsable' => 'Mario Saldaña',
        'address_id' => Address::find(1)->id,
        'bussiness_id' => Business::find(1)->id,
        ]);
    }
}
