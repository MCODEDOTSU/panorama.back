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
                'title' => 'Безопасность',
                'description' => 'Службы, отвечающие за безопасность в городе',
            ],
            '1' => [
                'id' => 2,
                'title' => 'Общественный транспорт',
                'description' => 'Остановки маршрутного транспорта, описание маршрутов',
            ],
            '2' => [
                'id' => 3,
                'title' => 'Торговля',
                'description' => 'Торговые точки города',
            ],
            '3' => [
                'id' => 4,
                'title' => 'ЖКХ',
                'description' => 'Программы жилищно-коммунального хозяйства',
            ],
            '4' => [
                'id' => 5,
                'title' => 'Отключения',
                'description' => 'Информация об отключении коммунальных услуг в городе',
            ],
            '5' => [
                'id' => 6,
                'title' => 'ТОС',
                'description' => 'Информация о территориально-общественных самоупралениях',
            ],
            '6' => [
                'id' => 7,
                'title' => 'Выборы',
                'description' => 'Информация о выборах, проводимых в городе',
            ]
        ];

        foreach ($data as $value) {
            DB::table('modules')->insert($value);
        }
    }
}
