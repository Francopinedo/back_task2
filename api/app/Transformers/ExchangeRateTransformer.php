<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\ExchangeRate;

class ExchangeRateTransformer extends TransformerAbstract
{

	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'currency'
    ];

    public function transform(ExchangeRate $exchangeRate)
    {
        return [
			'id'          => $exchangeRate->id,
			'currency_id' => $exchangeRate->currency_id,
			'company_id'  => $exchangeRate->company_id,
			'value'       => $exchangeRate->value,
			'quotation_date'       => $exchangeRate->quotation_date,
			'quotation_url'       => $exchangeRate->quotation_url
        ];
    }

    public function includeCurrency(ExchangeRate $exchangeRate)
    {
    	if (empty($exchangeRate->currency))
    	{
    		$currency = new Currency();
    	}
    	else{
    		$currency = $exchangeRate->currency;
    	}

        return $this->item($currency, new CurrencyTransformer);
    }
}
