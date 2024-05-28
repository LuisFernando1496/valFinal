<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSideers extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
       // $user = User::factory(10)->create();
        User::create([
            'name' => 'Administrador',
            'email' => 'admin@gmail.com',
            'password' =>  Hash::make('password'),
            'last_name' => 'system',
            'second_last_name'=> 'system2',
        ]);
    }
}
