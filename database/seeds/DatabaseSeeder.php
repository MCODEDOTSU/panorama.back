<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(ContractorSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(ModuleSeeder::class);
        $this->call(PrivilegesSeeder::class);
        $this->call(LayersSeeder::class);
        $this->call(ElementsSeeder::class);
        $this->call(SequenceUpdate::class);
    }
}
