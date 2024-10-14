<?php

use Illuminate\Database\Seeder;

class MetavariablesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('metavariables')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

         DB::table('metadocuments')->insert([
            [
                'id' => 1,
                'metavariable_kind_id' => 1,
                'name' => 'proyecto',
                'caption' => 'Indique el nombre del Proyecto',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 2,
                'metavariable_kind_id' => 2,
                'name' => 'fecha',
                'caption' => 'Indique la Fecha',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 3,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 4,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 5,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 6,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 7,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 8,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 9,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 10,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 11,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 12,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
            [
                'id' => 13,
                'metavariable_kind_id' => ,
                'name' => ,
                'caption' => '',
                'dependencies' => NULL,
                'metadocument_id' => 1,
                'width' => 50,
                'deleted_at' => NULL,
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ],
         ]);

    }
}
