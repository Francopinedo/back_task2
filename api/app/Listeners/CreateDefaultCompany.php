<?php

namespace App\Listeners;

use App\Events\UserRegisteredEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Dingo\Api\Routing\Helpers;

use App\Models\User;
use App\Models\Company;
use App\Models\UserCompany;

class CreateDefaultCompany
{
	use Helpers;

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
     * @param  UserRegisteredEvent  $event
     * @return void
     */
    public function handle(UserRegisteredEvent $event)
    {
        $user = User::findOrFail($event->user->id);

        $company = $this->api->post('companies', ['name' => 'My Company', 'user_id' => $user->id]);
    }
}
