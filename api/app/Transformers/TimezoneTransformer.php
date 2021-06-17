<?php

	namespace Transformers;

	use App\Models\Timezone;
	use League\Fractal\TransformerAbstract;

	class TimezoneTransformer extends TransformerAbstract
	{

		public function transform(Timezone $timezones)
	    {
	        return [
				'id'   => $timezones->id,
				'timezone' => $timezones->timezone
	        ];
	    }
	}