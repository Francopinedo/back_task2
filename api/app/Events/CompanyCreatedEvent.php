<?php

namespace App\Events;

use App\Models\Company;
use Illuminate\Queue\SerializesModels;

class CompanyCreatedEvent extends Event
{
	use SerializesModels;

    public $company;
    public $user_id;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Company $company, $user_id = NULL)
    {
        $this->company = $company;
        $this->user_id = $user_id;
    }
}
