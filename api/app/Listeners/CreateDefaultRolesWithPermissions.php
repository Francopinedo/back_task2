<?php

namespace App\Listeners;

use App\Events\CompanyCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Models\CompanyRole;
// use App\Models\CompanyRolePermission;
use App\Models\Permission;
use App\Models\Role;
use App\Models\PermissionRole;

class CreateDefaultRolesWithPermissions
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  CompanyCreatedEvent  $event
     * @return void
     */
    public function handle(CompanyCreatedEvent $event)
    {
    	// PM
    	// Creo el rol PM
        $company_role = CompanyRole::create(['title' => 'Project Manager', 'company_id' => $event->company->id]);

        // Estos son los lugares a donde tiene permiso el PM
        $permissions_slugs = ['view.mycompany', 'view.emails', 'execute.emails'];

    	// Creo un Role basado en el company_role
        $role = Role::create(['name' => $company_role->title, 'slug' => $company_role->id, 'company_role_id' => $company_role->id]);

        // Vinculo los permisos con el role
        $permissions = Permission::whereIn('slug', $permissions_slugs)->get();
    	foreach ($permissions as $permission)
    	{
    		PermissionRole::create(['permission_id' => $permission->id, 'role_id' => $role->id]);
    	}

    }
}
