<?php

namespace App\Listeners;

use App\Events\CompanyCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\CompanyRoleTemplate;
use App\Models\CompanyRole;
use App\Models\Role;

class CreateRelatedCompanyRoles
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
        $companyRoleTemplates = CompanyRoleTemplate::all();

        foreach ($companyRoleTemplates as $companyRoleTemplate)
        {
        	$companyRole = CompanyRole::create(['title' => $companyRoleTemplate->title, 'company_id' => $event->company->id]);
        	Role::create(['name' => $companyRoleTemplate->title, 'slug' => $companyRole->id, 'company_role_id' => $companyRole->id]);
        }
    }
}
