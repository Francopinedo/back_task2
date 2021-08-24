<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('roles')->truncate();
    	DB::table('role_user')->truncate();
    	DB::statement('SET FOREIGN_KEY_CHECKS=1;');
	    /**
	     * Add Roles
	     *
	     */
    	if (Role::where('name', '=', 'Super User')->first() === null) {
	        $adminRole = Role::create([
	            'name' => 'Super User',
	            'slug' => 'admin',
	            'description' => 'Super User',
	            'level' => 5,
        	]);
	    }

    	if (Role::where('name', '=', 'User')->first() === null) {
	        $userRole = Role::create([
	            'name' => 'User',
	            'slug' => 'user',
	            'description' => 'User Role',
	            'level' => 1,
	        ]);
	    }

    	// if (Role::where('name', '=', 'Unverified')->first() === null) {
	    //     $userRole = Role::create([
	    //         'name' => 'Unverified',
	    //         'slug' => 'unverified',
	    //         'description' => 'Unverified Role',
	    //         'level' => 0,
	    //     ]);
	    // }

    }

}