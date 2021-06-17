<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Models\ProcurementOffer;

class ProcurementOfferTransformer extends TransformerAbstract
{

	public function transform(ProcurementOffer $procurementOffer)
    {
        return [
        	'id'                        => $procurementOffer->id,
			'procurement_id'            => $procurementOffer->procurement_id,
			'description'               => $procurementOffer->description,
			'specifications'            => $procurementOffer->specifications,
			'delivery_max_days_offered' => $procurementOffer->delivery_max_days_offered,
			'delivery_responsable'      => $procurementOffer->delivery_responsable,
			'cost'                      => $procurementOffer->cost,
			'quality'                   => $procurementOffer->quality,
			'provider_id'               => $procurementOffer->provider_id,
			'comment'                   => $procurementOffer->comment,
        ];
    }
}