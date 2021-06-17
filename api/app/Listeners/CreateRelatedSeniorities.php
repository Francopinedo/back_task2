<?php

namespace App\Listeners;

use App\Events\CompanyCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\SeniorityTemplate;
use App\Seniority;

class CreateRelatedSeniorities
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
        $seniorityTemplates = SeniorityTemplate::all();

        foreach ($seniorityTemplates as $seniorityTemplate)
        {
        	Seniority::create(['title' => $seniorityTemplate->title, 'company_id' => $event->company->id]);
        }
    }
}
