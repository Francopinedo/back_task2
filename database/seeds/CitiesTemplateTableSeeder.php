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
        DB::table('cities_template')->truncate();
        DB::table('cities_template')->insert([
                [
                    'name' => 'Capital Federal',
                    'location_name' => 'Capital Federal',
                    'country_id' => 1,
                    'timezone' => 'GMT-3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Cordoba',
                    'location_name' => 'Provincia de Cordoba',
                    'country_id' => 1,
                    'timezone' => 'GMT-3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Sao Paulo',
                    'location_name' => 'Estado de Sao Paulo',
                    'country_id' => 4,
                    'timezone' => 'GMT-3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Bangalore',
                    'location_name' => 'Bangalore',
                    'country_id' => 5,
                    'timezone' => 'GMT-5.3',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Austin',
                    'location_name' => 'Texas',
                    'country_id' => 2,
                    'timezone' => 'GMT-5',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Bogota',
                    'location_name' => 'Bogota',
                    'country_id' => 3,
                    'timezone' => 'GMT-5',
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'name' => 'Bahia Blanca',
                    'location_name' => 'Bahia Blanca',
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
