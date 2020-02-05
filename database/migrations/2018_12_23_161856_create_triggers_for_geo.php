<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTriggersForGeo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared('
            CREATE OR REPLACE FUNCTION set_geometry_properties() RETURNS trigger AS $geometry_properties$
                BEGIN
                    NEW.length := ST_Length(NEW.geometry);
                    NEW.area := ST_Area(NEW.geometry);
                    NEW.perimeter := ST_Perimeter(NEW.geometry);
                    RETURN NEW;
                END;           
            $geometry_properties$ LANGUAGE plpgsql;
        ');
        DB::unprepared('
            CREATE TRIGGER set_geometry_properties
            BEFORE INSERT OR UPDATE ON geo_elements
            FOR EACH ROW EXECUTE PROCEDURE set_geometry_properties()
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS set_geometry_properties on geo_elements');
        DB::unprepared('DROP FUNCTION IF EXISTS set_geometry_properties() CASCADE');
    }
}
