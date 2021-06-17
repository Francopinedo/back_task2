<?php

namespace App\Listeners;

use App\Events\CompanyCreatedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\EmailCategoryTemplate;
use App\EmailCategory;

use App\EmailTemplate;
use App\Email;

class CreateRelatedEmailCategories
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
        $emailCategoryTemplates = EmailCategoryTemplate::all();

        foreach ($emailCategoryTemplates as $emailCategoryTemplate)
        {
        	// creo la categoria
        	$emailCategory = EmailCategory::create(['title' => $emailCategoryTemplate->title, 'company_id' => $event->company->id]);

        	// y luego creo todos los emails de esa categoria
	        $emailTemplates = EmailTemplate::where('email_category_template_id', $emailCategoryTemplate->id)->get();

	        foreach ($emailTemplates as $emailTemplate)
	        {
	        	Email::create([
					'title'             => $emailTemplate->title,
					'subject'           => $emailTemplate->subject,
					'body'              => $emailTemplate->body,
					'email_category_id' => $emailCategory->id
				]);
	        }
        }
    }
}
