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
            ],
            [
                'name' => 'd.potehin@mail.ru',
                'email' => 'd.potehin@mail.ru',
                'password' => '$2y$10$YLiQe7ldT6mAmp3Lbfpf.OBX0YboFEpZbaZa0DEcelra2H/n1R9HS',
                'contractor_id' => 2,
            ],
            [
                'name' => 'v.limonov@yandex.ru',
                'email' => 'v.limonov@yandex.ru',
                'password' => '$2y$10$q1.gQrfixjedBNO8IPGTKec.KyTGhli6yR4nwQMbeoMRGrtU1OPM2',
                'contractor_id' => 3,
            ],
            [
                'name' => 'leliaoff@ya.ru',
                'email' => 'leliaoff@ya.ru',
                'password' => '$2y$10$cFLtV8sAjTjnmRdJbG7oJOTXKXJp9K8uDU749/cadPF7alsSJW2ue',
                'contractor_id' => 4,
            ],
        ];

        foreach ($data as $value) {
            DB::table('users')->insert($value);
        }
    }
}
