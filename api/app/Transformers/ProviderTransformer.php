<?php

namespace Transformers;

use App\City;
use App\Country;
use App\Currency;
use App\Industry;
use App\Models\Provider;
use League\Fractal\TransformerAbstract;

class ProviderTransformer extends TransformerAbstract
{

	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'industry', 'country', 'city', 'currency'
    ];

    public function transform(Provider $provider)
    {
        return [
			'id'              => $provider->id,
			'name'            => $provider->name,
			'address'         => $provider->address,
			'country_id'	  => $provider->country_id,
			'city_id'         => $provider->city_id,
			'email_1'         => $provider->email_1,
			'email_2'         => $provider->email_2,
			'email_3'         => $provider->email_3,
			'phone_1'         => $provider->phone_1,
			'phone_2'         => $provider->phone_2,
			'phone_3'         => $provider->phone_3,
			'billing_name'    => $provider->billing_name,
			'billing_address' => $provider->billing_address,
			'tax_number'      => $provider->tax_number,
			'bank_name'       => $provider->bank_name,
			'account_number'  => $provider->account_number,
			'swiftcode'       => $provider->swiftcode,
			'aba'             => $provider->aba,
			'currency_id'     => $provider->currency_id,
			'industry_id'     => $provider->industry_id,
			'logo_path'     => $provider->logo_path
        ];
    }

    public function includeIndustry(Provider $provider)
    {
    	if (empty($provider->industry))
    	{
    		$industry = new Industry();
    	}
    	else{
    		$industry = $provider->industry;
    	}

        return $this->item($industry, new IndustryTransformer);
    }

    public function includeCountry(provider $provider)
    {
    	if (empty($provider->country))
    	{
    		$country = new Country();
    	}else{
    		$country = $provider->country;
    	}

    	return $this->item($country, new CountryTransformer);
    }

    public function includeCity(Provider $provider)
    {
    	if (empty($provider->city))
    	{
    		$city = new City();
    	}
    	else{
    		$city = $provider->city;
    	}

        return $this->item($city, new CityTransformer);
    }

    public function includeCurrency(Provider $provider)
    {
    	if (empty($provider->currency))
    	{
    		$currency = new Currency();
    	}
    	else{
    		$currency = $provider->currency;
    	}

        return $this->item($currency, new CurrencyTransformer);
    }
}
