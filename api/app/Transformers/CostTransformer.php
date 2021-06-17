<?php

namespace Transformers;

use League\Fractal\TransformerAbstract;
use App\Cost;
use App\Industry;
use App\City;
use App\Currency;

class CostTransformer extends TransformerAbstract
{

	/**
     * List of resources possible to include
     *
     * @var array
     */
    protected $availableIncludes = [
        'company', 'country', 'city', 'seniority', 'project_role', 'currency'
    ];

    public function transform(Cost $cost)
    {
        return [
			'id'              => $cost->id,
			'company_id'      => $cost->company_id,
			'country_id'      => $cost->country_id,
			'city_id'         => $cost->city_id,
			'seniority_id'    => $cost->seniority_id,
			'project_role_id' => $cost->project_role_id,
			'workplace'       => $cost->workplace,
			'detail'          => $cost->detail,
			'value'           => $cost->value,
			'currency_id'     => $cost->currency_id
        ];
    }

    public function includeCompany(Cost $cost)
    {
    	if (empty($cost->company))
    	{
    		$company = new Company();
    	}
    	else{
    		$company = $cost->company;
    	}

        return $this->item($company, new CompanyTransformer);
    }

    public function includeCountry(Cost $cost)
    {
    	if (empty($cost->country))
    	{
    		$city = new Country();
    	}
    	else{
    		$city = $cost->country;
    	}

        return $this->item($city, new CountryTransformer);
    }

    public function includeCity(Customer $cost)
    {
    	if (empty($cost->city))
    	{
    		$city = new City();
    	}
    	else{
    		$city = $cost->city;
    	}

        return $this->item($city, new CityTransformer);
    }

    public function includeCurrency(Customer $cost)
    {
    	if (empty($cost->currency))
    	{
    		$currency = new Currency();
    	}
    	else{
    		$currency = $cost->currency;
    	}

        return $this->item($currency, new CurrencyTransformer);
    }
}