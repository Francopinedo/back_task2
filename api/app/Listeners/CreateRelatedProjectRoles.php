<?php

namespace App\Listeners;

use App\Events\CompanyCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\ProjectRoleTemplate;
use App\ProjectRole;

class CreateRelatedProjectRoles
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
        $projectRoleTemplates = ProjectRoleTemplate::all();

        foreach ($projectRoleTemplates as $projectRoleTemplate)
        {
        	ProjectRole::create(['title' => $projectRoleTemplate->title, 'company_id' => $event->company->id]);
        }
    }
}
