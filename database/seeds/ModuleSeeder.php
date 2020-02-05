<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            '0' => [
                'id' => 1,
                'title' => 'ТОСы',
                'description' => 'Информация о территориально-общественных самоупралениях',
            ],
            '1' => [
                'id' => 2,
                'title' => 'Горсвет',
                'description' => 'МУНИЦИПАЛЬНОЕ КАЗЕННОЕ ПРЕДПРИЯТИЕ ГОРОДА АСТРАХАНИ "ГОРСВЕТ"',
            ],
            '2' => [
                'id' => 3,
                'title' => 'Кладбища',
                'description' => 'Информация о кладбищах и захоронениях',
            ],
        ];

        foreach ($data as $value) {
            DB::table('modules')->insert($value);
        }
    }
}
