<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class SeederTablaPermisos extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permisos = [

            //tabla business
            'ver-negocio',
            'editar-negocio',
            'crear-negocio',
            'borrar-negocio',

            //tabla offices
            'ver-oficina',
            'editar-oficina',
            'crear-oficina',
            'borrar-oficina',

            //tabla roles
            'ver-rol',
            'editar-rol',
            'crear-rol',
            'borrar-rol',

            //tabla usuarios
            'ver-usuarios',
            'editar-usuarios',
            'crear-usuarios',
            'borrar-usuarios',
            //tabla creditos
            'ver-creditos',
            'editar-creditos',
            'crear-creditos',
            'borrar-creditos',
            //tabla de gastos
            'ver-gastos',
            'editar-gastos',
            'crear-gastos',
            'borrar-gastos',

        ];

        foreach($permisos as $permiso)
        {
            Permission::create(['name' => $permiso]);
        }
    }
}
