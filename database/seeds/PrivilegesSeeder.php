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
                'contractor_id' => 1,
            ],
            '1' => [
                'module_id' => 2,
                'contractor_id' => 1,
            ],
            '2' => [
                'module_id' => 3,
                'contractor_id' => 1,
            ],
            '3' => [
                'module_id' => 4,
                'contractor_id' => 1,
            ],
            '4' => [
                'module_id' => 5,
                'contractor_id' => 1,
            ],
            '5' => [
                'module_id' => 6,
                'contractor_id' => 1,
            ],
            '6' => [
                'module_id' => 7,
                'contractor_id' => 1,
            ],
            [
                'module_id' => 2,
                'contractor_id' => 2,
            ],
            [
                'module_id' => 3,
                'contractor_id' => 2,
            ],
            [
                'module_id' => 7,
                'contractor_id' => 2,
            ],
            [
                'module_id' => 4,
                'contractor_id' => 3,
            ],
            [
                'module_id' => 5,
                'contractor_id' => 3,
            ],
            [
                'module_id' => 6,
                'contractor_id' => 3,
            ],
            [
                'module_id' => 1,
                'contractor_id' => 4,
            ],
        ];

        foreach ($data as $value) {
            DB::table('privileges')->insert($value);
        }
    }
}
