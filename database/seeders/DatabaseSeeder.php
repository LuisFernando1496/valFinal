<?php

namespace Database\Seeders;


use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
       
        // Client::create([
        //     'name' => 'Cliente',
        //     'last_name' => 'en',
        //     'second_last_name' => 'general',
            
        // ]);
        // \App\Models\User::factory(10)->create();
        $this->call([  
            SeederTablaPermisos::class,
            AddressSideers::class,
            BussinesSideers::class,
            OfficeSeeders::class,
            UserSideers::class,
            CategoryOfExpenseSeeder::class,
            OwnerSeeder::class,
            ExpensesSeeders::class,
            ClientsSeeders::class,
            Category_fTecnicaSeeder::class,
            Ficha_TecnicaSeeder::class
            ])
        ;
    }
}
