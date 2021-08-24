<?php

use Illuminate\Database\Seeder;

class HolidaysTemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('holidays_templates')->truncate();
        DB::table('holidays_templates')->insert([
            [
                'description' => 'Gral. Jose de San Martin step to inmortality',
                'date' => '2017-08-21',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'Cultural Diversity Day',
                'date' => '2017-10-16',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'National Souvereign Day',
                'date' => '2017-11-20',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'Immaculate Conception Of The Virgin Mary',
                'date' => '2017-12-08',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'New Year',
                'date' => '2018-01-01',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'Maundy Day',
                'date' => '2018-03-29',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'Labour Day',
                'date' => '2018-05-01',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'May Day Revolution',
                'date' => '2018-05-25',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'description' => 'National Flag Day',
                'date' => '2018-06-20',
                'country_id' => 1,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],

        ]);
    }
}
