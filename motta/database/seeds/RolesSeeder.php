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
            
            ['id' => 1, 'name' => 'Admin', 'guard_name' => 'web',],
            ['id' => 2, 'name' => 'Manifiesto administrador', 'guard_name' => 'web',],
            ['id' => 3, 'name' => 'Manifiesto cliente', 'guard_name' => 'web',],

        ];

        foreach ($items as $item) {
            \App\Rol::create($item);
        }
    }
}
