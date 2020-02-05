<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PrivilegesSeeder extends Seeder
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
                'module_id' => 1,
                'contractor_id' => 2,
            ],
            '1' => [
                'module_id' => 2,
                'contractor_id' => 2,
            ],
            '2' => [
                'module_id' => 3,
                'contractor_id' => 2,
            ],
        ];

        foreach ($data as $value) {
            DB::table('privileges')->insert($value);
        }
    }
}
