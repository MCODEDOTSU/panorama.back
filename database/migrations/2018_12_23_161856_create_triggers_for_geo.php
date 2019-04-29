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
            CREATE OR REPLACE FUNCTION SetLength()
              RETURNS trigger AS
            $$
                BEGIN   
                    SELECT ST_Length(NEW.geom)::text INTO NEW.length;
                    RETURN NEW;
                END
            $$
            LANGUAGE plpgsql
        ');
        DB::unprepared('
            CREATE TRIGGER SetLength
            BEFORE INSERT OR UPDATE
            ON geo_linestrings
            FOR EACH ROW
            EXECUTE PROCEDURE SetLength()
        ');
        DB::unprepared('
            CREATE OR REPLACE FUNCTION SetAreaPerimeter()
              RETURNS trigger AS
            $$
                BEGIN   
                    SELECT ST_Area(NEW.geom)::text INTO NEW.area;
                    SELECT ST_Perimeter(NEW.geom)::text INTO NEW.perimeter;
                    RETURN NEW;
                END
            $$
            LANGUAGE plpgsql
        ');
        DB::unprepared('
            CREATE TRIGGER SetAreaPerimeter
            BEFORE INSERT OR UPDATE
            ON geo_polygons
            FOR EACH ROW
            EXECUTE PROCEDURE SetAreaPerimeter()
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS SetAreaPerimeter on geo_polygons');
        DB::unprepared('DROP TRIGGER IF EXISTS SetLength on geo_linestrings');
        DB::unprepared('DROP FUNCTION IF EXISTS SetAreaPerimeter() CASCADE');
        DB::unprepared('DROP FUNCTION IF EXISTS SetLength() CASCADE');
    }
}
