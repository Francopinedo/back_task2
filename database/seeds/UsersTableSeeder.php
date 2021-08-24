<?php

use App\User;
use jeremykenedy\LaravelRoles\Models\Role;
use jeremykenedy\LaravelRoles\Models\Permission;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	DB::statement('SET FOREIGN_KEY_CHECKS=0;');
    	DB::table('users')->truncate();
    	DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $userRole 			= Role::where('name', '=', 'User')->first();
        $adminRole 			= Role::where('name', '=', 'Admin')->first();
		$permissions 		= Permission::all();

	    /**
	     * Add Users
	     *
	     */
        if (User::where('email', '=', 'superuser@taskcontrol.com')->first() === null) {

	        $newUser = User::create([
	            'name' => 'TASKCONTROL SUPERUSER',
	            'email' => 'superuser@taskcontrol.com',
	            'password' => bcrypt('password'),
	            'address' => 'Riobamba, CABA. ARG'
	        ]);

	        $newUser->attachRole($adminRole);
			foreach ($permissions as $permission) {
				$newUser->attachPermission($permission);
			}

        }

        // if (User::where('email', '=', 'admin@company.taskcontrol.com')->first() === null) {

	       //  $newUser = User::create([
	       //      'name' => 'Admin',
	       //      'email' => 'admin@company.taskcontrol.com',
	       //      'password' => bcrypt('password'),
	       //  ]);

	       //  $newUser;
	       //  $newUser->attachRole($userRole);

        // }

    }
}