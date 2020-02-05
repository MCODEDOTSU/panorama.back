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
                'title' => 'ТОСы',
                'module_id' => 1,
                'alias' => 'tos',
                'geometry_type' => 'polygon',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#ff7845","opacity":50},"stroke":{"color":"#e4352b","width":1}}'
            ],
            '1' => [
                'id' => 2,
                'title' => 'Опоры',
                'module_id' => 2,
                'alias' => 'opory',
                'geometry_type' => 'point',
                'style' => '{"shape":{"points":66,"fill":{"color":"#4FBBC5"},"stroke":{"color":"#6EBDC5","width":1},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}'
            ],
            '2' => [
                'id' => 3,
                'title' => 'Освещение',
                'module_id' => 2,
                'alias' => 'osveshhenie',
                'geometry_type' => 'point',
                'style' => '{"shape":{"points":66,"fill":{"color":"#F2665F"},"stroke":{"color":"#F28B86","width":1},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}'
            ],
            '3' => [
                'id' => 4,
                'title' => 'Кладбища',
                'module_id' => 3,
                'alias' => 'kladbishha',
                'geometry_type' => 'polygon',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#7a9700","opacity":50},"stroke":{"color":"#011c00","width":1}}'
            ],
            '4' => [
                'id' => 5,
                'title' => 'Захоронения',
                'module_id' => 3,
                'alias' => 'zahoronenija',
                'geometry_type' => 'polygon',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#009fe3","opacity":50},"stroke":{"color":"#164194","width":1}}'
            ],
        ];

        foreach ($data as $value) {
            DB::table('geo_layers')->insert($value);
        }
    }
}
