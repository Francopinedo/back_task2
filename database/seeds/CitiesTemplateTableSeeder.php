<?php

use Illuminate\Database\Seeder;

class CitiesTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cities_template')->insert([
                [
                    'name' => 'Bahia Blanca',
                    'location_name' => 'Bahia Blanca',
                    'country_id' => 1,
                    'timezone' => 'GMT-3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')

                ],
                [
                    'name' => 'Capital Federal',
                    'location_name' => 'Capital Federal',
                    'country_id' => 1,
                    'timezone' => 'GMT-3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Mar del Plata',
                    'location_name' => 'Mar del Plata',
                    'country_id' => 1,
                    'timezone' => 'GMT-3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],

                [
                    'name' => 'Salta la Linda',
                    'location_name' => 'Salta',
                    'country_id' => 1,
                    'timezone' => 'GMT-3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]]

        );
    }
}
