<?php

use Illuminate\Database\Seeder;

class AbsenceTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('absence_types')->insert([
                [
                    'country_id' => 1,
                    'city_id' => NULL,
                    'title' => 'Maternity License',
                    'days' => 90,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ], [
                    'country_id' => 1,
                    'city_id' => NULL,
                    'title' => 'Moving License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => NULL,
                    'title' => 'Paternity License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => NULL,
                    'title' => 'Marriage License',
                    'days' => 7,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => NULL,
                    'title' => 'Exam Day',
                    'days' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ]]

        );
    }
}
