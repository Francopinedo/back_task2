<?php

use Illuminate\Database\Seeder;

class MetagridsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('metagrids')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
