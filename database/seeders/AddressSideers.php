<?php

namespace Database\Seeders;

use App\Models\Address;
use Illuminate\Database\Seeder;

class AddressSideers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'street',
        // 'number',
        // 'suburb',
        // 'postal_code',
        // 'city',
        // 'state',
        // 'country'
       $addresses = [
       [
        'street' => 'Av. nogales',
        'number' => 45,
        'suburb' => 'San pedro villavista',
        'postal_code' => '29049',
        'city' => 'Tijuana',
        'state' => 'Baja California',
        'country' => 'Mexico'
        ],
        [
        'street' => 'Av. nogales',
        'number' => 45,
        'suburb' => 'San pedro villavista',
        'postal_code' => '29049',
        'city' => 'Tijuana',
        'state' => 'Baja California',
        'country' => 'Mexico'
        ]
        ];
        foreach ($addresses as $address) {
            Address::create($address);
        }
    }
}
