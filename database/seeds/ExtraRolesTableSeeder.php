<?php

use Illuminate\Database\Seeder;

class ExtraRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if (Role::where('name', '=', 'PM')->first() === null) {
	        $adminRole = Role::create([
	            'name' => 'Project Manager',
	            'slug' => 'pm',
	            'description' => 'PM Role',
	            'level' => 1,
        	]);
	    }
    }
}
