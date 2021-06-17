<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketHistory extends Model {

	protected $table = 'ticket_histories';
	public $timestamps = true;
	protected $fillable = array(
							'ticket_id',
							'date',
							'owner_id',
							'internal_or_external',
							'comment'
						);

}