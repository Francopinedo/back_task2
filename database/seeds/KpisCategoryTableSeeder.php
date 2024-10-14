<?php

use Illuminate\Database\Seeder;

class KpisCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('kpis_category')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('kpis_category')->insert([
            [
                'name' => 'Cost',
                'company_id' => 1,
                'roles' => json_encode(['Admin','Project Manager']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Schedule',
                'company_id' => 1,
                'roles' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Resources',
                'company_id' => 1,
                'roles' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Risk',
                'company_id' => 1,
                'roles' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Quality',
                'company_id' => 1,
                'roles' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Agile',
                'company_id' => 1,
                'roles' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ],
            [
                'name' => 'Dashboard',
                'company_id' => 1,
                'roles' => json_encode(['Admin','User','Project Manager','Delivery Manager','Technical Leader']),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s')
            ]
        ]);
    }
}
