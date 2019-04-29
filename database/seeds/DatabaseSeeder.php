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
        $this->call(ModuleSeeder::class);
        $this->call(LayersSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(ContractorSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(PrivilegesSeeder::class);
        $this->call(ElementsSeeder::class);
        $this->call(LayerCompositionSeeder::class);
        $this->call(GeometrySeeder::class);
        $this->call(SequenceUpdate::class);
    }
}
