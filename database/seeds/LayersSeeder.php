<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayersSeeder extends Seeder
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
                'title' => 'Аварийно-диспетчерские службы',
                'module_id' => 1,
                'alias' => 'safety_emergency'
            ],
            '1' => [
                'id' => 2,
                'title' => 'Опорные пункты полиции',
                'module_id' => 1,
                'alias' => 'safety_police_stations'
            ],
            '2' => [
                'id' => 3,
                'title' => 'Участковые',
                'module_id' => 1,
                'alias' => 'safety_police_men'
            ],
            '3' => [
                'id' => 4,
                'title' => 'Маршруты следования',
                'module_id' => 2,
                'alias' => 'transport_routes'
            ],
            '4' => [
                'id' => 5,
                'title' => 'Остановки',
                'module_id' => 2,
                'alias' => 'transport_stops'
            ],
            '5' => [
                'id' => 6,
                'title' => 'Объекты торговли',
                'module_id' => 3,
                'alias' => 'trading_objects'
            ],
            '6' => [
                'id' => 7,
                'title' => 'Управляющие компании',
                'module_id' => 4,
                'alias' => 'utilities_companies'
            ],
            '7' => [
                'id' => 8,
                'title' => 'Программа капитального ремонта',
                'module_id' => 4,
                'alias' => 'utilities_prog_repair'
            ],
            '8' => [
                'id' => 9,
                'title' => 'Программа благоустройства дворов',
                'module_id' => 4,
                'alias' => 'utilities_prog_development'
            ],
            '9' => [
                'id' => 10,
                'title' => 'Плановые',
                'module_id' => 5,
                'alias' => 'disconnections_planned'
            ],
            '10' => [
                'id' => 11,
                'title' => 'Аварийные',
                'module_id' => 5,
                'alias' => 'disconnections_emergency'
            ],
            '11' => [
                'id' => 12,
                'title' => 'ТОСы',
                'module_id' => 6,
                'alias' => 'tos_area'
            ],
            '12' => [
                'id' => 13,
                'title' => 'Избирательные участки',
                'module_id' => 7,
                'alias' => 'elections_points'
            ]

        ];

        foreach ($data as $value) {
            DB::table('geo_layers')->insert($value);
        }
    }
}
