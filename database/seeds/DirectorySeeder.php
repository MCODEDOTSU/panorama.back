<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DirectorySeeder extends Seeder
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
                'name' => 'contractors',
                'title' => 'Организации',
            ],
            [
                'id' => 2,
                'name' => 'persons',
                'title' => 'Физические Лица',
            ],
        ];

        foreach ($data as $value) {
            DB::table('directories')->insert($value);
        }
    }
}
