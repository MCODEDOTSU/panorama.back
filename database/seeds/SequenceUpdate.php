<?php

use Illuminate\Database\Seeder;

class SequenceUpdate extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::select("SELECT SETVAL('address_id_seq', (SELECT MAX(id) FROM address))");
        DB::select("SELECT SETVAL('contractors_id_seq', (SELECT MAX(id) FROM contractors))");
        DB::select("SELECT SETVAL('geo_layers_id_seq', (SELECT MAX(id) FROM geo_layers))");
        DB::select("SELECT SETVAL('modules_id_seq', (SELECT MAX(id) FROM modules))");
        DB::select("SELECT SETVAL('privileges_id_seq', (SELECT MAX(id) FROM privileges))");
        DB::select("SELECT SETVAL('users_id_seq', (SELECT MAX(id) FROM users))");
        DB::select("SELECT SETVAL('geo_elements_id_seq', (SELECT MAX(id) FROM geo_elements))");
        DB::select("SELECT SETVAL('geo_points_id_seq', (SELECT MAX(id) FROM geo_points))");
        DB::select("SELECT SETVAL('geo_linestrings_id_seq', (SELECT MAX(id) FROM geo_linestrings))");
        DB::select("SELECT SETVAL('geo_polygons_id_seq', (SELECT MAX(id) FROM geo_polygons))");
        DB::select("SELECT SETVAL('geo_layer_composition_id_seq', (SELECT MAX(id) FROM geo_layer_composition))");
    }
}
