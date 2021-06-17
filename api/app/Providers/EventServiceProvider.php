<?php

namespace App\Providers;

use Laravel\Lumen\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\CompanyCreatedEvent' => [
            'App\Listeners\CreateRelatedSeniorities',
            'App\Listeners\CreateRelatedCompanyRoles',
            'App\Listeners\CreateRelatedProjectRoles',
            'App\Listeners\CreateRelatedEmailCategories',
            'App\Listeners\CreateDefaultRolesWithPermissions'
        ],
        'App\Events\UserRegisteredEvent' => [
            'App\Listeners\AssignRole',
            'App\Listeners\CreateDefaultCompany'
        ],
    ];
}
