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
        DB::table('directories')->insert([
            [
                'id' => 1,
                'nombre' => 'Initial',
                'path' => 'initiating',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 2,
                'nombre' => 'Planning',
                'path' => 'planning',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 3,
                'nombre' => 'Executing',
                'path' => 'executing',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 4,
                'nombre' => 'Monitoring & Control',
                'path' => 'monitoring',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 5,
                'nombre' => 'Closing',
                'path' => 'closing',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 6,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 7,
                'nombre' => 'Minutes',
                'path' => 'minutes',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 8,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 9,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 10,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 11,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 1
            ],
            [
                'id' => 12,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 1
            ],


            [
                'id' => 13,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 14,
                'nombre' => 'Legal',
                'path' => 'legal',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 15,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 16,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 17,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 18,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 2
            ],
            [
                'id' => 19,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 2
            ],


            [
                'id' => 20,
                'nombre' => 'Minutes',
                'path' => 'minutes',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 21,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 22,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 23,
                'nombre' => 'Billing',
                'path' => 'billing',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 24,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 25,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 3
            ],
            [
                'id' => 26,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 3
            ],


            [
                'id' => 27,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 28,
                'nombre' => 'Legal',
                'path' => 'legal',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 29,
                'nombre' => 'Minutes',
                'path' => 'minutes',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 30,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 31,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 32,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 33,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 49
            ],
            [
                'id' => 34,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 49
            ],

            [
                'id' => 35,
                'nombre' => 'Minutes',
                'path' => 'minutes',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 36,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 37,
                'nombre' => 'Metrics',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 38,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 39,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 40,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 50
            ],
            [
                'id' => 41,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 50
            ],


            [
                'id' => 42,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 43,
                'nombre' => 'Metrics',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 44,
                'nombre' => 'Mails',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 45,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 46,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 51
            ],
            [
                'id' => 47,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 51
            ],

            [
                'id' => 48,
                'nombre' => 'Quality management',
                'path' => 'quality_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 49,
                'nombre' => 'Scope management',
                'path' => 'scope_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 50,
                'nombre' => 'Time management',
                'path' => 'time_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 51,
                'nombre' => 'Financial management',
                'path' => 'financial_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],


            [
                'id' => 52,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 53,
                'nombre' => 'Metrics',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 54,
                'nombre' => 'Mails',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 55,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 56,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 48
            ],
            [
                'id' => 57,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 48
            ],

            [
                'id' => 58,
                'nombre' => 'Human resources management',
                'path' => 'human_resources_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],


            [
                'id' => 59,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 58
            ],
            [
                'id' => 60,
                'nombre' => 'Metrics',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 58
            ],
            [
                'id' => 61,
                'nombre' => 'Mails',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 58
            ],
            [
                'id' => 62,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 58
            ],
            [
                'id' => 63,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 58
            ],
            [
                'id' => 64,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 58
            ],

            [
                'id' => 65,
                'nombre' => 'Comunications management',
                'path' => 'comunications_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],
            [
                'id' => 66,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 65
            ],
            [
                'id' => 67,
                'nombre' => 'Minutes',
                'path' => 'minutes',
                'borrado_logico' => 0,
                'parent' => 65
            ],
            [
                'id' => 68,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 65
            ],
            [
                'id' => 69,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 65
            ],
            [
                'id' => 70,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 65
            ],
            [
                'id' => 71,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 65
            ],
            [
                'id' => 72,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 65
            ],


            [
                'id' => 73,
                'nombre' => 'Stakeholder management',
                'path' => 'stakeholder_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],

            [
                'id' => 74,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 73
            ],
            [
                'id' => 75,
                'nombre' => 'Legal',
                'path' => 'legal',
                'borrado_logico' => 0,
                'parent' => 73
            ],
            [
                'id' => 76,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 73
            ],
            [
                'id' => 77,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 73
            ],
            [
                'id' => 78,
                'nombre' => 'Metrics',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 73
            ],

            [
                'id' => 79,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 73
            ],
            [
                'id' => 80,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 73
            ],
            [
                'id' => 81,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 73
            ],


            [
                'id' => 82,
                'nombre' => 'Risk management',
                'path' => 'risk_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],

            [
                'id' => 83,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 82
            ],

            [
                'id' => 84,
                'nombre' => 'Metrics',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 82
            ],
            [
                'id' => 85,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 82
            ],
            [
                'id' => 86,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 82
            ],
            [
                'id' => 87,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 82
            ],
            [
                'id' => 88,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 82
            ],



            [
                'id' => 89,
                'nombre' => 'Procurement management',
                'path' => 'stakeholder_management',
                'borrado_logico' => 0,
                'parent' => 4
            ],

            [
                'id' => 90,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 89
            ],
            [
                'id' => 91,
                'nombre' => 'Legal',
                'path' => 'legal',
                'borrado_logico' => 0,
                'parent' => 89
            ],
            [
                'id' => 92,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 89
            ],
            [
                'id' => 93,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 89
            ],
            [
                'id' => 94,
                'nombre' => 'Metrics',
                'path' => 'metrics',
                'borrado_logico' => 0,
                'parent' => 89
            ],

            [
                'id' => 95,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 89
            ],
            [
                'id' => 96,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 89
            ],
            [
                'id' => 97,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 89
            ],


            [
                'id' => 98,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 5
            ],

            [
                'id' => 99,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 100,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 101,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 102,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 5
            ],
            [
                'id' => 103,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 5
            ],


            [
                'id' => 104,
                'nombre' => 'Initiation',
                'path' => 'initiation',
                'borrado_logico' => 0,
                'parent' => NULL
            ],

            [
                'id' => 105,
                'nombre' => 'Plans',
                'path' => 'plans',
                'borrado_logico' => 0,
                'parent' => 104
            ],
            [
                'id' => 106,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 104
            ],
            [
                'id' => 107,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 104
            ],

            [
                'id' => 108,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 104
            ],
            [
                'id' => 109,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 104
            ],
            [
                'id' => 110,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 104
            ],




            [
                'id' => 111,
                'nombre' => 'Requirements',
                'path' => 'requirements',
                'borrado_logico' => 0,
                'parent' => NULL
            ],

            [
                'id' => 112,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 111
            ],

            [
                'id' => 113,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 111
            ],

            [
                'id' => 114,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 111
            ],
            [
                'id' => 115,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 111
            ],
            [
                'id' => 116,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 111
            ],



            [
                'id' => 117,
                'nombre' => 'Design',
                'path' => 'design',
                'borrado_logico' => 0,
                'parent' => NULL
            ],

            [
                'id' => 118,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 117
            ],

            [
                'id' => 119,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 117
            ],

            [
                'id' => 120,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 117
            ],
            [
                'id' => 121,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 117
            ],
            [
                'id' => 122,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 117
            ],



            [
                'id' => 123,
                'nombre' => 'Builds',
                'path' => 'builds',
                'borrado_logico' => 0,
                'parent' => NULL
            ],

            [
                'id' => 124,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 123
            ],

            [
                'id' => 125,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 123
            ],

            [
                'id' => 126,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 123
            ],
            [
                'id' => 127,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 123
            ],
            [
                'id' => 128,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 123
            ],




            [
                'id' => 129,
                'nombre' => 'Testing',
                'path' => 'testing',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 130,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 129
            ],

            [
                'id' => 131,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 129
            ],

            [
                'id' => 132,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 129
            ],
            [
                'id' => 133,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 129
            ],
            [
                'id' => 134,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 129
            ],



            [
                'id' => 135,
                'nombre' => 'Implementation',
                'path' => 'testing',
                'borrado_logico' => 0,
                'parent' => NULL
            ],
            [
                'id' => 136,
                'nombre' => 'Reports',
                'path' => 'reports',
                'borrado_logico' => 0,
                'parent' => 135
            ],

            [
                'id' => 137,
                'nombre' => 'Mails',
                'path' => 'mails',
                'borrado_logico' => 0,
                'parent' => 135
            ],

            [
                'id' => 138,
                'nombre' => 'Others',
                'path' => 'others',
                'borrado_logico' => 0,
                'parent' => 135
            ],
            [
                'id' => 139,
                'nombre' => 'Archives',
                'path' => 'archives',
                'borrado_logico' => 0,
                'parent' => 135
            ],
            [
                'id' => 140,
                'nombre' => 'Public',
                'path' => 'public',
                'borrado_logico' => 0,
                'parent' => 135
            ],
        ]);
    }
}
