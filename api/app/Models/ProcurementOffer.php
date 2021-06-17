<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementOffer extends Model {

	protected $table = 'procurement_offers';
	public $timestamps = true;
	protected $fillable = array(
							'procurement_id',
							'description',
							'specifications',
							'delivery_max_days_offered',
							'delivery_responsable',
							'cost',
							'quality',
							'provider_id',
							'comment'
						);

}