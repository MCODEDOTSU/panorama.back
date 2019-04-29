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
                'name' => 'ООО Тест',
                'full_name' => 'Общество с ограниченной ответственностью Тестовая разработка',
                'inn' => '1234567890',
                'kpp' => '1234567789',
                'address_id' => 1,
            ],
            [
                'id' => 2,
                'name' => 'ООО "РЕАЛЬНЫЙ ГОРОД"',
                'full_name' => 'ОБЩЕСТВО С ОГРАНИЧЕННОЙ ОТВЕТСТВЕННОСТЬЮ "РЕАЛЬНЫЙ ГОРОД"',
                'inn' => '3019015479',
                'kpp' => '301901001',
                'address_id' => 72,
            ],
            [
                'id' => 3,
                'name' => 'ООО "РЕАЛ"',
                'full_name' => 'НТС "Реал", ООО',
                'inn' => '3015060720',
                'kpp' => '301501001',
                'address_id' => 73,
            ],
            [
                'id' => 4,
                'name' => 'Мастер Кода',
                'full_name' => 'ИП Сироткина Е.И.',
                'inn' => '301711648261',
                'address_id' => 74,
            ],
        ];

        foreach ($data as $value) {
            DB::table('contractors')->insert($value);
        }
    }
}
