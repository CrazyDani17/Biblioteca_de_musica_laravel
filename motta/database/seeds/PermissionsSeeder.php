<?php

use Illuminate\Database\Seeder;


class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $items = [
            
            ['id' => 1, 'name' => 'manifiestos_administrador', 'guard_name' => 'web', ],
            ['id' => 2, 'name' => 'planilla', 'guard_name' => 'web',],
            ['id' => 3, 'name' => 'manifiestos_cliente', 'guard_name' => 'web',],
            ['id' => 4, 'name' => 'administrador', 'guard_name' => 'web',],

        ];
/*
        foreach ($items as $item) {
            \App\User::create($item);
        }*/
    }
}



