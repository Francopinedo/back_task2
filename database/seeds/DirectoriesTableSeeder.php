<?php

use Illuminate\Database\Seeder;

class DirectoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('directories')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        DB::table('directories')->insert([
            [
                'id' => 1,
                'nombre' => 'EN',
                'path' => 'EN',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 2,
                'nombre' => 'ES',
                'path' => 'ES',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 3,
                'nombre' => 'Initiating',
                'path' => '1-Initial',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 4,
                'nombre' => 'Planning',
                'path' => '2-Planning',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 5,
                'nombre' => 'Executing',
                'path' => '3-Executing',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 6,
                'nombre' => 'Monitoring y Control',
                'path' => '4-Monitoring_Control',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 7,
                'nombre' => 'Closing',
                'path' => '5-Closing',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 8,
                'nombre' => 'Integration Management',
                'path' => '1-Integration_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 9,
                'nombre' => 'Scope Management',
                'path' => '2-Scope_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 10,
                'nombre' => 'Time Management',
                'path' => '3-Time_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 11,
                'nombre' => 'Cost Management',
                'path' => '4-Cost_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 12,
                'nombre' => 'Quality Management',
                'path' => '5-Quality_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 13,
                'nombre' => 'Team Management',
                'path' => '6-Team_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 14,
                'nombre' => 'Communication Management',
                'path' => '7-Communication_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 15,
                'nombre' => 'Risk Management',
                'path' => '8-Risk_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 16,
                'nombre' => 'Stakeholder Management',
                'path' => '9-Stakeholder_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 17,
                'nombre' => 'Procurement Management',
                'path' => '10-Procurement_Management',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 18,
                'nombre' => 'Integration Management',
                'path' => '1-Integration_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 19,
                'nombre' => 'Scope Management',
                'path' => '2-Scope_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 20,
                'nombre' => 'Time Management',
                'path' => '3-Time_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 21,
                'nombre' => 'Cost Management',
                'path' => '4-Cost_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 22,
                'nombre' => 'Quality Management',
                'path' => '5-Quality_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],


            [
                'id' => 23,
                'nombre' => 'Team Management',
                'path' => '6-Team_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 24,
                'nombre' => 'Communication Management',
                'path' => '7-Communication_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 25,
                'nombre' => 'Risk Management',
                'path' => '8-Risk_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 26,
                'nombre' => 'Stakeholder Management',
                'path' => '9-Stakeholder_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 27,
                'nombre' => 'Procurement Management',
                'path' => '10-Procurement_Management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 28,
                'nombre' => 'Integration Management',
                'path' => '1-Integration_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 29,
                'nombre' => 'Scope Management',
                'path' => '2-Scope_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 30,
                'nombre' => 'Time Management',
                'path' => '3-Time_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 31,
                'nombre' => 'Cost Management',
                'path' => '4-Cost_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 32,
                'nombre' => 'Quality Management',
                'path' => '5-Quality_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],


            [
                'id' => 33,
                'nombre' => 'Team Management',
                'path' => '6-Team_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 34,
                'nombre' => 'Communication Management',
                'path' => '7-Communication_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 35,
                'nombre' => 'Risk Management',
                'path' => '8-Risk_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 36,
                'nombre' => 'Stakeholder Management',
                'path' => '9-Stakeholder_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 37,
                'nombre' => 'Procurement Management',
                'path' => '10-Procurement_Management',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 38,
                'nombre' => 'Integration Management',
                'path' => '1-Integration_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 39,
                'nombre' => 'Scope Management',
                'path' => '2-Scope_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 40,
                'nombre' => 'Time Management',
                'path' => '3-Time_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 41,
                'nombre' => 'Cost Management',
                'path' => '4-Cost_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 42,
                'nombre' => 'Quality Management',
                'path' => '5-Quality_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 43,
                'nombre' => 'Team Management',
                'path' => '6-Team_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 44,
                'nombre' => 'Communication Management',
                'path' => '7-Communication_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 45,
                'nombre' => 'Risk Management',
                'path' => '8-Risk_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 46,
                'nombre' => 'Stakeholder Management',
                'path' => '9-Stakeholder_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 47,
                'nombre' => 'Procurement Management',
                'path' => '10-Procurement_Management',
                'borrado_logico' => 0,
                'parent' => 6
            ],
            [
                'id' => 48,
                'nombre' => 'Integration Management',
                'path' => '1-Integration_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 49,
                'nombre' => 'Scope Management',
                'path' => '2-Scope_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 50,
                'nombre' => 'Time Management',
                'path' => '3-Time_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 51,
                'nombre' => 'Cost Management',
                'path' => '4-Cost_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 52,
                'nombre' => 'Quality Management',
                'path' => '5-Quality_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 53,
                'nombre' => 'Team Management',
                'path' => '6-Team_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 54,
                'nombre' => 'Communication Management',
                'path' => '7-Communication_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 55,
                'nombre' => 'Risk Management',
                'path' => '8-Risk_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 56,
                'nombre' => 'Stakeholder Management',
                'path' => '9-Stakeholder_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 57,
                'nombre' => 'Procurement Management',
                'path' => '10-Procurement_Management',
                'borrado_logico' => 0,
                'parent' => 7
            ],
            [
                'id' => 58,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 59,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 60,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 61,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 62,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 63,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 64,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 65,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 66,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 8
            ],
            [
                'id' => 67,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 68,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 69,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 70,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 71,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 72,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 73,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 74,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 75,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 9
            ],
            [
                'id' => 76,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 77,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 78,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 79,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 80,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 81,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 82,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 83,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 84,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 10
            ],
            [
                'id' => 85,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 86,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 87,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 88,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 89,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 90,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 91,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 92,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 93,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 11
            ],
            [
                'id' => 94,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 95,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 96,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 97,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 98,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 99,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 100,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 101,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 102,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 12
            ],
            [
                'id' => 103,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 104,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 105,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 106,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 107,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 108,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 109,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 110,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 111,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 13
            ],
            [
                'id' => 112,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 113,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 114,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 115,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 116,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 117,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 118,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 119,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 120,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 14
            ],
            [
                'id' => 121,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 122,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 123,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 124,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 125,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 126,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 127,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 128,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 129,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 15
            ],
            [
                'id' => 130,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 131,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 132,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 133,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 134,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 135,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 136,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 137,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 138,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 16
            ],
            [
                'id' => 139,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 140,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 141,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 142,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 143,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 144,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 145,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 146,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 147,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 17
            ],
            [
                'id' => 148,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 149,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 150,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 151,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 152,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 153,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 154,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 155,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 156,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 18
            ],
            [
                'id' => 157,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 158,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 159,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 160,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 161,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 162,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 163,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 164,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 165,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 19
            ],
            [
                'id' => 166,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 167,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 168,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 169,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 170,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 171,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 172,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 173,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 174,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 20
            ],
            [
                'id' => 175,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 176,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 177,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 178,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 179,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 180,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 181,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 182,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 183,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 21
            ],
            [
                'id' => 184,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 185,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 186,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 187,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 188,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 189,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 190,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 191,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 192,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 22
            ],
            [
                'id' => 193,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 194,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 195,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 196,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 197,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 198,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 199,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 200,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 201,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 23
            ],
            [
                'id' => 202,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 203,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 204,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 205,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 206,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 207,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 208,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 209,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 210,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 24
            ],
            [
                'id' => 211,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 212,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 213,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 214,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 215,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 216,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 217,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 218,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 219,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 25
            ],
            [
                'id' => 220,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 221,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 222,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 223,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 224,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 225,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 226,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 227,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 228,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 26
            ],
            [
                'id' => 229,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 230,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 231,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 232,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 233,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 234,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 235,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 236,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 237,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 27
            ],
            [
                'id' => 238,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 239,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 240,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 241,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 242,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 243,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 244,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 245,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 246,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 28
            ],
            [
                'id' => 247,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 248,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 249,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 250,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 251,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 252,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 253,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 254,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 255,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 29
            ],
            [
                'id' => 256,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 257,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 258,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 259,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 260,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 261,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 262,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 263,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 264,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 30
            ],
            [
                'id' => 265,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 266,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 267,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 268,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 269,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 270,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 271,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 272,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 273,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 31
            ],
            [
                'id' => 274,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 275,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 276,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 277,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 278,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 279,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 280,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 281,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 282,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 32
            ],
            [
                'id' => 283,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 284,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 285,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 286,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 287,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 288,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 289,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 290,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 33
            ],
            [
                'id' => 291,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 33
            ],

            [
                'id' => 292,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 293,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 294,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 295,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 296,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 297,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 298,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 299,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 34
            ],
            [
                'id' => 300,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 34
            ],

            [
                'id' => 301,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 302,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 303,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 304,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 305,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 306,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 307,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 308,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 35
            ],
            [
                'id' => 309,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 35
            ],

            [
                'id' => 310,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 311,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 312,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 313,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 314,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 315,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 316,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 317,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 36
            ],
            [
                'id' => 318,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 36
            ],

            [
                'id' => 319,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 320,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 321,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 322,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 323,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 324,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 325,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 326,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 37
            ],
            [
                'id' => 327,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 37
            ],

            [
                'id' => 328,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 329,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 330,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 331,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 332,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 333,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 334,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 335,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 38
            ],
            [
                'id' => 336,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 38
            ],

            [
                'id' => 337,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 338,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 339,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 340,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 341,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 342,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 343,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 344,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 39
            ],
            [
                'id' => 345,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 39
            ],

            [
                'id' => 346,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 347,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 348,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 349,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 350,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 351,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 352,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 353,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 40
            ],
            [
                'id' => 354,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 40
            ],

            [
                'id' => 355,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 356,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 357,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 358,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 359,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 360,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 361,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 362,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 41
            ],
            [
                'id' => 363,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 41
            ],

            [
                'id' => 364,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 365,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 366,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 367,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 368,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 369,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 370,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 371,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 42
            ],
            [
                'id' => 372,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 42
            ],

            [
                'id' => 373,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 374,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 375,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 376,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 377,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 378,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 379,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 380,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 43
            ],
            [
                'id' => 381,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 43
            ],

            [
                'id' => 382,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 383,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 384,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 385,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 386,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 387,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 388,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 389,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 44
            ],
            [
                'id' => 390,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 44
            ],

            [
                'id' => 391,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 392,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 393,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 394,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 395,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 396,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 397,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 398,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 45
            ],
            [
                'id' => 399,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 45
            ],

            [
                'id' => 401,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 402,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 403,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 404,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 405,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 406,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 407,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 408,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 46
            ],
            [
                'id' => 409,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 46
            ],

            [
                'id' => 410,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 411,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 412,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 413,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 414,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 415,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 416,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 417,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 47
            ],
            [
                'id' => 418,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 47
            ],

            [
                'id' => 419,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 420,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 421,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 422,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 423,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 424,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 425,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 426,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 427,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 48
            ],

            [
                'id' => 428,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 429,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 430,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 431,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 432,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 433,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 434,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 435,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 436,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 49
            ],

            [
                'id' => 437,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 438,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 439,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 440,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 441,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 442,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 443,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 444,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 445,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 446,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 447,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 448,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 449,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 450,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 451,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 452,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 453,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 454,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 51
            ],

            [
                'id' => 455,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 456,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 457,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 458,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 459,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 460,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 461,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 462,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 52
            ],
            [
                'id' => 463,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 52
            ],

            [
                'id' => 464,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 465,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 466,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 467,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 468,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 469,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 470,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 471,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 53
            ],
            [
                'id' => 472,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 53
            ],

            [
                'id' => 473,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 474,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 475,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 476,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 477,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 478,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 479,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 480,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 54
            ],
            [
                'id' => 481,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 54
            ],

            [
                'id' => 482,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 483,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 484,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 485,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 486,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 487,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 488,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 489,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 55
            ],
            [
                'id' => 490,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 55
            ],

            [
                'id' => 491,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 492,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 493,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 494,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 495,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 496,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 497,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 498,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 56
            ],
            [
                'id' => 499,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 56
            ],

            [
                'id' => 500,
                'nombre' => 'Urgent',
                'path' => '1-Urgent',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 501,
                'nombre' => 'Mails',
                'path' => '2-Mails',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 502,
                'nombre' => 'Minutes',
                'path' => '3-Minutes',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 503,
                'nombre' => 'Reports',
                'path' => '4-Reports',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 504,
                'nombre' => 'Legal',
                'path' => '5-Legal',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 505,
                'nombre' => 'Plans',
                'path' => '6-Plans',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 506,
                'nombre' => 'Metrics',
                'path' => '7-Metrics',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 507,
                'nombre' => 'Others',
                'path' => '8-Others',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 508,
                'nombre' => 'Archives',
                'path' => '9-Archives',
                'borrado_logico' => 0,
                'parent' => 57
            ],
            [
                'id' => 509,
                'nombre' => 'Iniciacion',
                'path' => '1-Inicio',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 510,
                'nombre' => 'Planificacion',
                'path' => '2-Planificacion',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 511,
                'nombre' => 'Ejecucion',
                'path' => '3-Ejecucion',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 512,
                'nombre' => 'Monitoreo y Control',
                'path' => '4-Monitoreo_Control',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 513,
                'nombre' => 'Cierre',
                'path' => '5-Cierre',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 514,
                'nombre' => 'Manejo de la Integracion',
                'path' => '1-Manejo_Integracion',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 515,
                'nombre' => 'Manejo del Alcance',
                'path' => '2-Manejo_Alcance',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 516,
                'nombre' => 'Manejo del Tiempo',
                'path' => '3-Manejo_Tiempo',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 517,
                'nombre' => 'Manejo de Cosos',
                'path' => '4-Manejo_Costos',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 518,
                'nombre' => 'Manejo de Calidad',
                'path' => '5-Manejo_Calidad',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 519,
                'nombre' => 'Manejo del Equipo',
                'path' => '6-Manejo_Equipo',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 520,
                'nombre' => 'Manejo de las Comunicaciones',
                'path' => '7-Manejo_Comunicaciones',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 521,
                'nombre' => 'Manjo de los Riesgos',
                'path' => '8-Manejo_Riesgos',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 522,
                'nombre' => 'Manejo de los Interesados',
                'path' => '9-Manejo_Interesados',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 523,
                'nombre' => 'Manejo de las Adquisiciones',
                'path' => '10-Manejo_Adquisiciones',
                'borrado_logico' => 0,
                'parent' => 508
            ],
            [
                'id' => 524,
                'nombre' => 'Manejo de la Integracion',
                'path' => '1-Manejo_Integracion',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 525,
                'nombre' => 'Manejo del Alcance',
                'path' => '2-Manejo_Alcance',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 526,
                'nombre' => 'Manejo del Tiempo',
                'path' => '3-Manejo_Tiempo',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 527,
                'nombre' => 'Manejo de Cosos',
                'path' => '4-Manejo_Costos',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 528,
                'nombre' => 'Manejo de Calidad',
                'path' => '5-Manejo_Calidad',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 529,
                'nombre' => 'Manejo del Equipo',
                'path' => '6-Manejo_Equipo',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 530,
                'nombre' => 'Manejo de las Comunicaciones',
                'path' => '7-Manejo_Comunicaciones',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 531,
                'nombre' => 'Manjo de los Riesgos',
                'path' => '8-Manejo_Riesgos',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 532,
                'nombre' => 'Manejo de los Interesados',
                'path' => '9-Manejo_Interesados',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 533,
                'nombre' => 'Manejo de las Adquisiciones',
                'path' => '10-Manejo_Adquisiciones',
                'borrado_logico' => 0,
                'parent' => 509
            ],
            [
                'id' => 534,
                'nombre' => 'Manejo de la Integracion',
                'path' => '1-Manejo_Integracion',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 535,
                'nombre' => 'Manejo del Alcance',
                'path' => '2-Manejo_Alcance',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 536,
                'nombre' => 'Manejo del Tiempo',
                'path' => '3-Manejo_Tiempo',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 537,
                'nombre' => 'Manejo de Cosos',
                'path' => '4-Manejo_Costos',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 538,
                'nombre' => 'Manejo de Calidad',
                'path' => '5-Manejo_Calidad',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 539,
                'nombre' => 'Manejo del Equipo',
                'path' => '6-Manejo_Equipo',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 540,
                'nombre' => 'Manejo de las Comunicaciones',
                'path' => '7-Manejo_Comunicaciones',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 541,
                'nombre' => 'Manjo de los Riesgos',
                'path' => '8-Manejo_Riesgos',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 542,
                'nombre' => 'Manejo de los Interesados',
                'path' => '9-Manejo_Interesados',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 543,
                'nombre' => 'Manejo de las Adquisiciones',
                'path' => '10-Manejo_Adquisiciones',
                'borrado_logico' => 0,
                'parent' => 510
            ],
            [
                'id' => 544,
                'nombre' => 'Manejo de la Integracion',
                'path' => '1-Manejo_Integracion',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 545,
                'nombre' => 'Manejo del Alcance',
                'path' => '2-Manejo_Alcance',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 546,
                'nombre' => 'Manejo del Tiempo',
                'path' => '3-Manejo_Tiempo',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 547,
                'nombre' => 'Manejo de Cosos',
                'path' => '4-Manejo_Costos',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 548,
                'nombre' => 'Manejo de Calidad',
                'path' => '5-Manejo_Calidad',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 549,
                'nombre' => 'Manejo del Equipo',
                'path' => '6-Manejo_Equipo',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 550,
                'nombre' => 'Manejo de las Comunicaciones',
                'path' => '7-Manejo_Comunicaciones',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 551,
                'nombre' => 'Manjo de los Riesgos',
                'path' => '8-Manejo_Riesgos',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 552,
                'nombre' => 'Manejo de los Interesados',
                'path' => '9-Manejo_Interesados',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 553,
                'nombre' => 'Manejo de las Adquisiciones',
                'path' => '10-Manejo_Adquisiciones',
                'borrado_logico' => 0,
                'parent' => 511
            ],
            [
                'id' => 554,
                'nombre' => 'Manejo de la Integracion',
                'path' => '1-Manejo_Integracion',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 555,
                'nombre' => 'Manejo del Alcance',
                'path' => '2-Manejo_Alcance',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 556,
                'nombre' => 'Manejo del Tiempo',
                'path' => '3-Manejo_Tiempo',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 557,
                'nombre' => 'Manejo de Cosos',
                'path' => '4-Manejo_Costos',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 558,
                'nombre' => 'Manejo de Calidad',
                'path' => '5-Manejo_Calidad',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 559,
                'nombre' => 'Manejo del Equipo',
                'path' => '6-Manejo_Equipo',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 560,
                'nombre' => 'Manejo de las Comunicaciones',
                'path' => '7-Manejo_Comunicaciones',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 561,
                'nombre' => 'Manjo de los Riesgos',
                'path' => '8-Manejo_Riesgos',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 562,
                'nombre' => 'Manejo de los Interesados',
                'path' => '9-Manejo_Interesados',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 563,
                'nombre' => 'Manejo de las Adquisiciones',
                'path' => '10-Manejo_Adquisiciones',
                'borrado_logico' => 0,
                'parent' => 512
            ],
            [
                'id' => 564,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 565,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 566,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 567,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 568,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 569,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 570,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 571,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 572,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 513
            ],
            [
                'id' => 573,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 574,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 575,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 576,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 577,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 578,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 579,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 580,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 581,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 514
            ],
            [
                'id' => 582,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 583,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 584,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 585,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 586,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 587,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 588,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 589,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 590,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 515
            ],
            [
                'id' => 591,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 592,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 593,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 594,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 595,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 596,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 597,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 598,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            [
                'id' => 599,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 516
            ],
            
            [
                'id' => 600,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 601,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 602,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 603,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 604,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 605,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 606,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 607,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 517
            ],
            [
                'id' => 608,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 517
            ],

            [
                'id' => 609,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 610,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 611,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 612,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 613,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 614,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 615,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 616,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 518
            ],
            [
                'id' => 617,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 518
            ],

            [
                'id' => 618,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 619,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 620,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 621,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 622,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 623,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 624,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 625,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 519
            ],
            [
                'id' => 626,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 519
            ],

            [
                'id' => 627,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 628,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 629,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 630,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 631,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 632,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 633,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 634,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 520
            ],
            [
                'id' => 635,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 520
            ],

            [
                'id' => 636,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 637,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 638,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 639,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 640,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 641,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 642,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 643,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 521
            ],
            [
                'id' => 644,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 521
            ],

            [
                'id' => 645,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 646,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 647,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 648,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 649,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 650,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 651,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 652,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 522
            ],
            [
                'id' => 653,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 522
            ],

            [
                'id' => 654,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 655,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 656,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 657,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 658,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 659,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 660,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 661,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 523
            ],
            [
                'id' => 662,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 523
            ],

            [
                'id' => 663,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 664,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 665,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 666,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 667,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 668,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 669,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 670,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 524
            ],
            [
                'id' => 671,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 524
            ],

            [
                'id' => 672,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 673,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 674,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 675,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 676,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 677,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 678,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 679,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 525
            ],
            [
                'id' => 680,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 525
            ],

            [
                'id' => 681,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 682,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 683,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 684,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 685,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 686,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 687,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 688,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 526
            ],
            [
                'id' => 689,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 526
            ],

            [
                'id' => 690,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 691,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 692,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 693,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 694,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 695,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 696,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 697,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 527
            ],
            [
                'id' => 698,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 527
            ],

            [
                'id' => 699,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 700,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 701,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 702,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 703,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 704,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 705,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 706,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 528
            ],
            [
                'id' => 707,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 528
            ],

            [
                'id' => 708,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 709,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 710,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 711,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 712,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 713,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 714,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 715,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 529
            ],
            [
                'id' => 716,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 529
            ],

            [
                'id' => 717,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 718,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 719,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 720,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 721,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 722,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 723,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 724,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 530
            ],
            [
                'id' => 725,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 530
            ],

            [
                'id' => 726,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 727,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 728,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 729,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 730,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 731,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 732,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 733,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 531
            ],
            [
                'id' => 734,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 531
            ],

            [
                'id' => 735,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 736,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 737,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 738,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 739,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 740,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 741,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 742,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 532
            ],
            [
                'id' => 743,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 532
            ],

            [
                'id' => 744,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 745,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 746,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 747,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 748,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 749,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 750,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 751,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 533
            ],
            [
                'id' => 752,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 533
            ],

            [
                'id' => 753,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 754,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 755,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 756,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 757,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 758,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 759,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 760,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 534
            ],
            [
                'id' => 761,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 534
            ],

            [
                'id' => 762,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 763,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 764,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 765,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 766,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 767,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 768,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 769,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 535
            ],
            [
                'id' => 770,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 535
            ],

            [
                'id' => 771,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 772,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 773,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 774,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 775,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 776,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 777,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 778,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 536
            ],
            [
                'id' => 779,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 536
            ],

            [
                'id' => 780,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 781,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 782,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 783,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 784,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 785,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 786,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 787,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 537
            ],
            [
                'id' => 788,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 537
            ],

            [
                'id' => 789,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 790,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 791,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 792,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 793,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 794,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 795,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 796,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 538
            ],
            [
                'id' => 797,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 538
            ],

            [
                'id' => 798,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 799,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 800,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 801,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 802,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 803,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 804,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 805,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 539
            ],
            [
                'id' => 806,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 539
            ],

            [
                'id' => 807,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 808,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 809,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 810,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 811,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 812,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 813,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 814,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 540
            ],
            [
                'id' => 815,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 540
            ],

            [
                'id' => 816,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 817,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 818,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 819,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 820,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 821,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 822,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 823,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 541
            ],
            [
                'id' => 824,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 541
            ],

            [
                'id' => 825,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 826,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 827,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 828,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 829,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 830,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 831,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 832,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 542
            ],
            [
                'id' => 833,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 542
            ],

            [
                'id' => 834,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 835,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 836,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 837,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 838,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 839,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 840,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 841,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 543
            ],
            [
                'id' => 842,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 543
            ],

            [
                'id' => 843,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 844,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 845,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 846,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 847,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 848,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 849,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 850,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 544
            ],
            [
                'id' => 851,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 544
            ],

            [
                'id' => 852,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 853,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 854,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 855,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 856,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 857,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 858,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 859,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 545
            ],
            [
                'id' => 860,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 545
            ],

            [
                'id' => 861,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 862,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 863,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 864,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 865,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 866,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 867,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 868,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 546
            ],
            [
                'id' => 869,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 546
            ],

            [
                'id' => 870,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 881,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 882,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 883,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 884,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 885,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 886,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 887,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 547
            ],
            [
                'id' => 888,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 547
            ],

            [
                'id' => 889,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 890,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 891,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 892,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 893,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 894,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 895,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 896,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 548
            ],
            [
                'id' => 897,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 548
            ],

            [
                'id' => 898,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 899,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 900,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 901,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 902,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 903,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 904,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 905,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 549
            ],
            [
                'id' => 906,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 549
            ],

            [
                'id' => 907,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 908,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 909,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 910,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 911,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 912,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 913,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 914,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 550
            ],
            [
                'id' => 915,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 550
            ],

            [
                'id' => 916,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 917,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 918,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 919,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 920,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 921,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 922,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 923,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 551
            ],
            [
                'id' => 924,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 551
            ],

            [
                'id' => 925,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 926,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 927,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 928,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 929,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 930,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 931,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 932,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 552
            ],
            [
                'id' => 933,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 552
            ],

            [
                'id' => 934,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 935,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 936,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 937,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 938,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 939,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 940,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 941,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 553
            ],
            [
                'id' => 942,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 553
            ],

            [
                'id' => 943,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 944,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 945,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 946,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 947,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 948,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 949,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 950,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 554
            ],
            [
                'id' => 951,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 554
            ],

            [
                'id' => 952,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 953,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 954,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 955,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 956,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 957,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 958,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 959,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 960,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 555
            ],
            [
                'id' => 961,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 962,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 963,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 964,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 965,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 966,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 967,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 968,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 969,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 556
            ],
            [
                'id' => 970,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 971,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 972,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 973,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 974,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 975,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 976,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 977,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 978,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 557
            ],
            [
                'id' => 979,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 980,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 981,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 982,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 983,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 984,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 985,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 986,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 987,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 558
            ],
            [
                'id' => 988,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 989,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 990,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 991,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 992,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 993,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 994,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 995,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 996,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 559
            ],
            [
                'id' => 997,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 998,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 999,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 1000,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 1001,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 1002,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 1003,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 1004,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 1005,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 560
            ],
            [
                'id' => 1006,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1007,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1008,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1009,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1010,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1011,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1012,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1013,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1014,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 561
            ],
            [
                'id' => 1015,
                'nombre' => 'Urgente',
                'path' => '1-Urgente',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1016,
                'nombre' => 'Correos',
                'path' => '2-Correos',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1017,
                'nombre' => 'Minutas',
                'path' => '3-Minutas',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1018,
                'nombre' => 'Reportes',
                'path' => '4-Reportes',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1019,
                'nombre' => 'Legales',
                'path' => '5-Legales',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1020,
                'nombre' => 'Planes',
                'path' => '6-Planes',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1021,
                'nombre' => 'Metricas',
                'path' => '7-Metricas',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1022,
                'nombre' => 'Otros',
                'path' => '8-Otros',
                'borrado_logico' => 0,
                'parent' => 562
            ],
            [
                'id' => 1023,
                'nombre' => 'Archivo',
                'path' => '9-Archivo',
                'borrado_logico' => 0,
                'parent' => 562
            ],

            
        ]);
    }
}
