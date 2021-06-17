<?php

use Illuminate\Database\Seeder;

class MetavariableKindsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name_es' => 'Texto','name_en' => 'Text'],
            ['name_es' => 'Fecha','name_en' => 'Date'],
            ['name_es' => 'Número','name_en' => 'Number'],
            ['name_es' => 'Porcentaje','name_en' => 'Percentage'],
            ['name_es' => 'Link Imagen','name_en' => 'Image link'],
            ['name_es' => 'Link Externo','name_en' => 'Hyperlink'],
        ];

        foreach ($data as $d)
        {

            //Vemos si ya existe
            $exist = \App\MetavariableKind::where('name_es','=',$d['name_es'])->first();
   
            if (empty($exist))
            {
                \App\MetavariableKind::create([
                    'name_es' => $d['name_es'],
                    'name_en' => $d['name_en'],            
                ]);
            }
            
        }
    }
}
