<?php

use Illuminate\Database\Seeder;

class AbsenceTypesTemplateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('absence_types_template')->truncate();
        DB::table('absence_types_template')->insert([
                [
                    'country_id' => 1,
                    'city_id' => 1,
                    'title' => 'Maternity License',
                    'days' => 90,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ], [
                    'country_id' => 1,
                    'city_id' => 1,
                    'title' => 'Moving License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 1,
                    'title' => 'Paternity License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 1,
                    'title' => 'Marriage License',
                    'days' => 7,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 1,
                    'title' => 'Exam Day',
                    'days' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],


                [
                    'country_id' => 1,
                    'city_id' => 2,
                    'title' => 'Maternity License',
                    'days' => 90,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ], [
                    'country_id' => 1,
                    'city_id' => 2,
                    'title' => 'Moving License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 2,
                    'title' => 'Paternity License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 2,
                    'title' => 'Marriage License',
                    'days' => 7,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 2,
                    'title' => 'Exam Day',
                    'days' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],


                [
                    'country_id' => 1,
                    'city_id' => 3,
                    'title' => 'Maternity License',
                    'days' => 90,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ], [
                    'country_id' => 1,
                    'city_id' => 3,
                    'title' => 'Moving License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 3,
                    'title' => 'Paternity License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 3,
                    'title' => 'Marriage License',
                    'days' => 7,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 3,
                    'title' => 'Exam Day',
                    'days' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Maternity License',
                    'days' => 90,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ], [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Moving License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Paternity License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Marriage License',
                    'days' => 7,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Exam Day',
                    'days' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Maternity License',
                    'days' => 90,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ], [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Moving License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Paternity License',
                    'days' => 2,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Marriage License',
                    'days' => 7,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
                [
                    'country_id' => 1,
                    'city_id' => 4,
                    'title' => 'Exam Day',
                    'days' => 1,
                    'created_at' => date('Y-m-d H:i:s'),
                    'updated_at' => date('Y-m-d H:i:s')
                ],
            ]

        );
    }
}
