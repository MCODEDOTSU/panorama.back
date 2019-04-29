<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayerCompositionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            [
                'id' => 1,
                'layer_id' => 1,
                'geometry_type' => 'point',
                'title' => 'Аварийно-диспетчерская служба',
                'style' => '{"shape":{"points":66,"fill":{"color":"#F2665F"},"stroke":{"color":"#F28B86","width":1},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}',
            ],
            [
                'id' => 2,
                'layer_id' => 2,
                'geometry_type' => 'point',
                'title' => 'Опорный пункт полиции',
                'style' => '{"shape":{"points":66,"fill":{"color":"#4FBBC5"},"stroke":{"color":"#6EBDC5","width":1},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}',
            ],
            [
                'id' => 3,
                'layer_id' => 3,
                'geometry_type' => 'point',
                'title' => 'Участковый',
                'style' => '{"shape":{"points":66,"fill":{"color":"#B7E95B"},"stroke":{"color":"#5D8A0D","width":3},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}',
            ],
            [
                'id' => 4,
                'layer_id' => 4,
                'geometry_type' => 'linestring',
                'title' => 'Маршрут следования',
                'style' => '{"stroke":{"color":"#009fe3","opacity":80,"width":10},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"placement":"line","textBaseline":"bottom"}}',
            ],
            [
                'id' => 5,
                'layer_id' => 4,
                'geometry_type' => 'point',
                'title' => 'Остановка',
                'style' => '{"shape":{"points":66,"fill":{"color":"#009fe3"},"stroke":{"color":"#164194","width":1},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}',
            ],
            [
                'id' => 6,
                'layer_id' => 5,
                'geometry_type' => 'point',
                'title' => 'Остановка',
                'style' => '{"shape":{"points":66,"fill":{"color":"#009fe3"},"stroke":{"color":"#164194","width":1},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}',
            ],
            [
                'id' => 7,
                'layer_id' => 6,
                'geometry_type' => 'point',
                'title' => 'Объект торговли',
                'style' => '{"shape":{"points":66,"fill":{"color":"#f8d90f"},"stroke":{"color":"#db5000","width":1},"radius":5},"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6}}',
            ],
            [
                'id' => 8,
                'layer_id' => 7,
                'geometry_type' => 'polygon',
                'title' => 'Многоэтажный дом',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#009fe3","opacity":50},"stroke":{"color":"#164194","width":1}}',
            ],
            [
                'id' => 9,
                'layer_id' => 8,
                'geometry_type' => 'polygon',
                'title' => 'Многоэтажный дом',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#009fe3","opacity":50},"stroke":{"color":"#164194","width":1}}',
            ],
            [
                'id' => 10,
                'layer_id' => 9,
                'geometry_type' => 'polygon',
                'title' => 'Придомовая территория',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#7a9700","opacity":50},"stroke":{"color":"#011c00","width":1}}',
            ],
            [
                'id' => 11,
                'layer_id' => 10,
                'geometry_type' => 'polygon',
                'title' => 'Многоэтажный дом',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#009fe3","opacity":50},"stroke":{"color":"#164194","width":1}}',
            ],
            [
                'id' => 12,
                'layer_id' => 11,
                'geometry_type' => 'polygon',
                'title' => 'Многоэтажный дом',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#009fe3","opacity":50},"stroke":{"color":"#164194","width":1}}',
            ],
            [
                'id' => 13,
                'layer_id' => 12,
                'geometry_type' => 'polygon',
                'title' => 'Территория ТОС',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#ff7845","opacity":50},"stroke":{"color":"#e4352b","width":1}}',
            ],
            [
                'id' => 14,
                'layer_id' => 13,
                'geometry_type' => 'polygon',
                'title' => 'Избирательный участок',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#ff4b44","opacity":50},"stroke":{"color":"#760007","width":1}}',
            ],
            [
                'id' => 15,
                'layer_id' => 7,
                'geometry_type' => 'polygon',
                'title' => 'Территория УК',
                'style' => '{"font":{"font":"16px Calibri, sans-serif","fill":{"color":"#000000"},"stroke":{"color":"#ffffff","width":3},"textBaseline":"bottom","offsetY":-6},"fill":{"color":"#FFA540","opacity":20},"stroke":{"color":"#FF8700","width":1}}',
            ],
        ];

        foreach ($data as $value) {
            DB::table('geo_layer_composition')->insert($value);
        }
    }
}
