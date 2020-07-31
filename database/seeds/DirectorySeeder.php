<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ContractorSeeder extends Seeder
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
                'name' => 'Администратор',
                'full_name' => 'Администратор',
                'inn' => '301711648261',
            ],
            [
                'id' => 2,
                'name' => 'ООО "РЕАЛЬНЫЙ ГОРОД"',
                'full_name' => 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РЕАЛЬНЫЙ ГОРОД"',
                'inn' => '3019015479',
                'kpp' => '301901001',
            ],
        ];

        foreach ($data as $value) {
            DB::table('contractors')->insert($value);
        }
    }
}
