<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
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
                'name' => 'admin',
                'email' => 'admin@admin.ru',
                'password' => '$2y$10$wpykVVvmViUdDG1fDPYMQe4DU/CNBPXUZ8d8KRhQZiGAh52EajKma',
                'contractor_id' => 1,
                'role' => 'superadmin'
            ],
            [
                'name' => 'user',
                'email' => 'user@user.ru',
                'password' => '$2y$10$wpykVVvmViUdDG1fDPYMQe4DU/CNBPXUZ8d8KRhQZiGAh52EajKma',
                'contractor_id' => 2,
                'role' => 'admin'
            ],
        ];

        foreach ($data as $value) {
            DB::table('users')->insert($value);
        }
    }
}
